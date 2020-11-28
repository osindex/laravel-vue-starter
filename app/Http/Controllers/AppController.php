<?php

namespace App\Http\Controllers;

use App\Models\Ry\Student;
use App\Models\SysUser;
use Hongyukeji\LaravelSettings\Context;
use Illuminate\Http\Request;

// 通用组件的操作
class AppController extends Controller
{
    public function settingGet(Request $request, $key)
    {
        $default = $request->get('default');
        if ($request->has('context')) {
            $res = settings($key, $default, $this->contextAdj($request->context));
        } else {
            $res = \Settings::get($key, $default);
        }
        // dd($res);
        return $this->dataSuccess($res);
    }
    public function settingSet(Request $request)
    {
        // dd($request->all());

        if ($request->has('context')) {
            settings($request->except('context'), $this->contextAdj($request->context));
        } else {
            \Settings::set(...$request->all());
        }
        return $this->created();
    }
    public function settingDel(Request $request, $key)
    {
        if ($request->has('context')) {
            \Settings::context($this->contextAdj($request->context))->forget($key);
        } else {
            \Settings::forget($key);
        }
        return $this->noContent();
    }
    private function contextAdj($value = '')
    {
        // return $value;
        $cValue = json_decode($value, 1);
        // dd($cValue, $value);
        return new Context(is_array($cValue) ? $cValue : ['primary' => $cValue]);
        // return new Context(is_array($cValue) ? $cValue : ['primary' => (int) $cValue]);
    }
    public function wechat()
    {
        $APIs = [
            'chooseImage', 'getLocation',
        ];
        $officialAccount = \EasyWeChat::officialAccount(); // 公众号
        $config = $officialAccount->jssdk->buildConfig($APIs, $debug = true, $beta = false, $json = true);

        return $this->dataSuccess($config);
    }
    public function classInfo($id)
    {
        $list = Student::with('person')->where('class_id', $id)->get()->map(function ($item) {
            if (!$item->person) {
                unset($item->person);
                // 先注销关联
                $item->person = [
                    'phone_number' => '',
                    'qq' => '',
                    'weixin' => '',
                    'autograph' => '',
                ];
            }
            return $item;
        });
        return $this->dataSuccess($list);
    }
    public function openid(Request $request)
    {
        $find = [
            'openid' => $request->openid,
        ];
        $data = [
            'nick_name' => $request->nickname ?? '微信用户',
            'user_name' => 'wx_student:' . $request->openid,
        ];
        $user = SysUser::firstOrCreate($find, $data);
        // dd($user);
        $user->load('student');
        $token = $user->createToken('admin')->accessToken;
        $data = [
            'access_token' => $token,
            'user' => $user,
            'student' => $user->student,
        ];
        // $password = strlen($password) === 32 ? $password : md5($password);
        // dd(Hash::check($request->password, $user->getAuthPassword()), $user);
        // if ($request->withData) {
        //     $data['user'] = $user;
        // }
        return $this->dataSuccess($data);
    }
    public function bind(Request $request)
    {
        // dd($request->all());
        if ($request->has('id')) {
            $find = [
                'openid' => $request->openid,
            ];
            $data = [
                'phonenumber' => $request->phoneNumber,
                'user_name' => 'wx_student:' . $request->openid,
            ];
            if ($request->has('nickname')) {
                $data['nick_name'] = $request->nickname;
            }
            $user = SysUser::firstOrCreate($find, $data);
            // toggle
            try {
                $user->student()->attach($request->id);
            } catch (\Exception $e) {
                // return $this->badRequest('该用户已绑定！');
            }
            $user->load('student');
            return $this->dataSuccess($user);
        } else {
            return $this->badRequest('未选择信息，请返回上一步！');
        }
    }
    public function unbind(Request $request)
    {
        // dd(user());
        $user = user(); //SysUser::where($find)->first();
        // dd($request->all(), $user->student()->detach($request->id));
        $user->student()->detach($request->id);
        return $this->accepted();
    }

    private function cachePack($key, $request)
    {
        // \Cache::delete($key);
        if (\Cache::has($key . md5(json_encode($request->all())))) {
            $data = \Cache::get($key . md5(json_encode($request->all())));
        } else {
            // 缓存
            $data = $this->$key($request, false);
            \Cache::add($key . md5(json_encode($request->all())), $data, 15);
            // 15s
        }
        return $this->dataSuccess($data);
    }
    public function dataPackIndex(Request $request, $cache = true)
    {
        if ($cache) {
            return $this->cachePack('dataPackIndex', $request);
        }
        $sall = Student::where('id', '>', 10)->count();
        return compact('sall');
    }

}
