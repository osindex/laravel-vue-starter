<?php
use Hongyukeji\LaravelSettings\Context;

function contextAdj($value = '')
{
    return $value;
    $cValue = json_decode($value, 1);
    // dd($cValue, $value, new Context(['primary' => $value]));
    return new Context(is_array($cValue) ? $cValue : ['primary' => $value]);
}

/**
 * 根据出生日期计算年龄、生肖、星座
 * @param string $date = "2018-10-23" 日期
 * @param string $symbol 符号
 * @return $array
 * */
if (!function_exists('scanLocalDir')) {

    function birthdayComputer($birth, $symbol = '-')
    {
        if (!$birth) {
            return [
                'age' => 0,
                'zodiac' => null,
                'constellation' => null,
            ];
        }
        //计算年龄
        if ($symbol) {
            list($by, $bm, $bd) = explode($symbol, $birth);
        } else {
            $by = substr($birth, 0, 4);
            $bm = substr($birth, 4, 2);
            $bd = substr($birth, 6, 2);
        }
        $cm = date('n');
        $cd = date('j');
        $age = date('Y') - $by - 1;
        if ($cm > $bm || $cm == $bm && $cd > $bd) {
            $age++;
        }

        $array['age'] = $age > 0 ? $age : 0;

        //计算生肖
        $zodiac = [
            '鼠', '牛', '虎', '兔', '龙', '蛇',
            '马', '羊', '猴', '鸡', '狗', '猪',
        ];
        $key = ($by - 1900) % 12;
        $array['zodiac'] = $zodiac[$key] ?? '未填写';

        //计算星座
        $constellation_name = [
            '水瓶座', '双鱼座', '白羊座', '金牛座', '双子座', '巨蟹座',
            '狮子座', '处女座', '天秤座', '天蝎座', '射手座', '摩羯座',
        ];
        if ($bd <= 22) {
            if ('1' !== $bm) {
                $constellation = $constellation_name[$bm - 2] ?? '未填写';
            } else {
                $constellation = $constellation_name[11] ?? '未填写';
            }

        } else {
            $constellation = $constellation_name[$bm - 1] ?? '未填写';
        }

        $array['constellation'] = $constellation;

        return $array;
    }
}

if (!function_exists('dateRange')) {
    /**
     * 获取2个时间点之间所有的日期
     *
     * @param $first string|\Carbon\Carbon 开始时间
     * @param $next string|\Carbon\Carbon 结束时间
     * @param $format string|null 格式化
     * @return array    日期数组
     * @throws Exception
     */
    function dateRange($first, $next, $format = null)
    {
        $first = new \Carbon\Carbon($first);
        $next = new \Carbon\Carbon($next);

        $dates = [];
        for ($date = $first; $date->lte($next); $date->addDay()) {
            $dates[] = $format ? $date->format($format) : $date->toDateString();
        }

        return $dates;
    }
}

if (!function_exists('getUniqueNum')) {
    function getUniqueNum($model, $key, $prefix = '', $length = 16, $mix = true)
    {
        $strlength = $length - strlen($prefix);
        $shortened = str_limit($prefix . ($strlength > 8 ? date('Ymd') : '') . ($mix ? (md5(microtime() . mt_rand(1, 10000))) : mt_rand(pow(10, $strlength - 1), pow(10, $strlength))), $length, '');
        $record = $model::where($key, '=', $shortened)->first();
        if (!empty($record)) {
            // echo $shortened;
            return getUniqueNum($model, $key, $prefix, $length, $mix);
        } else {
            return $shortened;
        }
    }
}
if (!function_exists('random')) {
    function random($length = 32)
    {
        return Str::random($length);
    }
}

/**
 * number2chinese description
 *
 * · 个，十，百，千，万，十万，百万，千万，亿，十亿，百亿，千亿，万亿，十万亿，
 *   百万亿，千万亿，兆；此函数亿乘以亿为兆
 *
 * · 以「十」开头，如十五，十万，十亿等。两位数以上，在数字中部出现，则用「一十几」，
 *   如一百一十，一千零一十，一万零一十等
 *
 * · 「二」和「两」的问题。两亿，两万，两千，两百，都可以，但是20只能是二十，
 *   200用二百也更好。22,2222,2222是「二十二亿两千二百二十二万两千二百二十二」
 *
 * · 关于「零」和「〇」的问题，数字中一律用「零」，只有页码、年代等编号中数的空位
 *   才能用「〇」。数位中间无论多少个0，都读成一个「零」。2014是「两千零一十四」，
 *   20014是「二十万零一十四」，201400是「二十万零一千四百」
 *
 * 参考：https://jingyan.baidu.com/article/636f38bb3cfc88d6b946104b.html
 *
 * 人民币写法参考：[正确填写票据和结算凭证的基本规定](http://bbs.chinaacc.com/forum-2-35/topic-1181907.html)
 *
 * @param  minx  $number
 * @param  boolean $isRmb
 * @return string
 */
function number2chinese($number, $isRmb = false)
{
    // 判断正确数字
    if (!preg_match('/^-?\d+(\.\d+)?$/', $number)) {
        throw new Exception('number2chinese() wrong number', 1);
    }
    list($integer, $decimal) = explode('.', $number . '.0');
    // 检测是否为负数
    $symbol = '';
    if (substr($integer, 0, 1) == '-') {
        $symbol = '负';
        $integer = substr($integer, 1);
    }
    if (preg_match('/^-?\d+$/', $number)) {
        $decimal = null;
    }
    $integer = ltrim($integer, '0');
    // 准备参数
    $numArr = ['', '一', '二', '三', '四', '五', '六', '七', '八', '九', '.' => '点'];
    $descArr = ['', '十', '百', '千', '万', '十', '百', '千', '亿', '十', '百', '千', '万亿', '十', '百', '千', '兆', '十', '百', '千'];
    if ($isRmb) {
        $number = substr(sprintf("%.5f", $number), 0, -1);
        $numArr = ['', '壹', '贰', '叁', '肆', '伍', '陆', '柒', '捌', '玖', '.' => '点'];
        $descArr = ['', '拾', '佰', '仟', '万', '拾', '佰', '仟', '亿', '拾', '佰', '仟', '万亿', '拾', '佰', '仟', '兆', '拾', '佰', '仟'];
        $rmbDescArr = ['角', '分', '厘', '毫'];
    }
    // 整数部分拼接
    $integerRes = '';
    $count = strlen($integer);
    if ($count > max(array_keys($descArr))) {
        throw new Exception('number2chinese() number too large.', 1);
    } else if ($count == 0) {
        $integerRes = '零';
    } else {
        for ($i = 0; $i < $count; $i++) {
            $n = $integer[$i]; // 位上的数
            $j = $count - $i - 1; // 单位数组 $descArr 的第几位
            // 零零的读法
            $isLing = $i > 1// 去除首位
             && $n !== '0' // 本位数字不是零
             && $integer[$i - 1] === '0'; // 上一位是零
            $cnZero = $isLing ? '零' : '';
            $cnNum = $numArr[$n];
            // 单位读法
            $isEmptyDanwei = ($n == '0' && $j % 4 != 0) // 是零且一断位上
             || substr($integer, $i - 3, 4) === '0000'; // 四个连续0
            $descMark = isset($cnDesc) ? $cnDesc : '';
            $cnDesc = $isEmptyDanwei ? '' : $descArr[$j];
            // 第一位是一十
            if ($i == 0 && $cnNum == '一' && $cnDesc == '十') {
                $cnNum = '';
            }

            // 二两的读法
            $isChangeEr = $n > 1 && $cnNum == '二' // 去除首位
             && !in_array($cnDesc, ['', '十', '百']) // 不读两\两十\两百
             && $descMark !== '十'; // 不读十两
            if ($isChangeEr) {
                $cnNum = '两';
            }

            $integerRes .= $cnZero . $cnNum . $cnDesc;
        }
    }
    // 小数部分拼接
    $decimalRes = '';
    $count = strlen($decimal);
    if ($decimal === null) {
        $decimalRes = $isRmb ? '整' : '';
    } else if ($decimal === '0') {
        $decimalRes = $isRmb ? '' : '零';
    } else if ($count > max(array_keys($descArr))) {
        throw new Exception('number2chinese() number too large.', 1);
    } else {
        for ($i = 0; $i < $count; $i++) {
            if ($isRmb && $i > count($rmbDescArr) - 1) {
                break;
            }

            $n = $decimal[$i];
            if (!$isRmb) {
                $cnZero = $n === '0' ? '零' : '';
                $cnNum = $numArr[$n];
                $cnDesc = '';
                $decimalRes .= $cnZero . $cnNum . $cnDesc;
            } else {
                // 零零的读法
                $isLing = $i > 0// 去除首位
                 && $n !== '0' // 本位数字不是零
                 && $decimal[$i - 1] === '0'; // 上一位是零
                $cnZero = $isLing ? '零' : '';
                $cnNum = $numArr[$n];
                $cnDesc = $cnNum ? $rmbDescArr[$i] : '';
                $decimalRes .= $cnZero . $cnNum . $cnDesc;
            }
        }
    }
    // 拼接结果
    $res = $symbol . (
        $isRmb
        ? $integerRes . ($decimalRes === '' ? '元整' : "元$decimalRes")
        : $integerRes . ($decimalRes === '' ? '' : "点$decimalRes")
    );
    return $res;
}

function makeCourse($course = '')
{
    $dates = $course->classdate;
    $times = $course->classtime;
    $tempDate = timearray($dates, $times, $course->timetype, $course->weekday, $course->classnum, $course->dontdate);
    return $tempDate;
}
/**
 * 时间差
 * @param  [非时间戳] $begin_time [计算会转换为时间戳]
 * @param  [非时间戳] $end_time   [计算会转换为时间戳]
 * 日期 时间 时间类型 每周几 剩余排课次数 不排课时间
 * @return [返回间隔天数的数组]             [description]
 */
function timearray($date, $time, $timetype = "0", $week = "0", $days = "1", $unsetdate = [])
{
    if ($date[0] < $date[1]) {
        $startdate = $date[0];
        $enddate = $date[1];
    } else {
        $startdate = $date[1];
        $enddate = $date[0];
    }
    if ($time[0] < $time[1]) {
        $starttime = $time[0];
        $endtime = $time[1];
    } else {
        $starttime = $time[1];
        $endtime = $time[0];
    }
    // dd($startdate, $starttime, $endtime, $timetype, $week, $days, $unsetdate);
    // 两个时间的差
    // 需要的天数
    $num = 0;
    $resDate = [];
    // $timetype = 0;
    // 每周时间 如果第一天不是这个时间则选择属于周X的日期
    if ($timetype == '0') {
        $weekStartDate = date("w", strtotime($startdate));
        // dd($weekStartDate, $startdate);
        $diffDay = $weekStartDate - $week;
        if ($diffDay) {
            if ($diffDay > 0) {
                // 下一个周$week
                $needDays = 7 - abs($diffDay);
            } else {
                $needDays = abs($diffDay);
            }
            // 可以用英文的 不过数字更好计算
            $startdate = date('Y-m-d', strtotime($startdate . ' +' . $needDays . ' days'));
            // dd($weekStartDate, $week, $needDays, $startdate);
        }
    }
    for ($i = 0; $i < $days; $i++) {
        $time = $timetype == '0' ? date("Y-m-d", (strtotime($startdate) + intval(604800 * $i))) : date("Y-m-d", (strtotime($startdate) + intval(86400 * $i)));
        // 每周 或 每天
        // if (str_contains($unsetdate, $time)) {
        if (is_array($unsetdate) && in_array($time, $unsetdate)) {
            // 新版本存的是数组
            $days++;
            continue;
        }
        $num++;
        $resDate[] = [$time . ' ' . $starttime, $time . ' ' . $endtime, $num];
    }
    return $resDate;
}
/**
 * 查看的金额 传入单位 分[showAmount description]
 * @param  string $value [description]
 * @return [type]        [description]
 */
function showAmount($value = '')
{
    return bcdiv($value, 100, 2);
}
/**
 * 支付的金额 传入单位 元[payAmount description]
 * @param  string $value [description]
 * @return [type]        [description]
 */
function payAmount($value = '')
{
    return bcmul($value, 100, 2);
}

/**
 * 根据公式算出实际收费
 * @param  [type] $items [description]
 * @return [type]        [description]
 */
function sale_price($items = null, $rateNeed = false)
{
    $gongshi = [
        [
            'min' => 2,
            'rate' => 0.95,
        ],
        [
            'min' => 3,
            'rate' => 0.85,
        ],
        [
            'min' => 4,
            'rate' => 0.8,
        ],
    ];
    if (is_null($items)) {
        $items = collect([
            [
                'amount' => 3000,
            ], [
                'amount' => 2000,
            ], [
                'amount' => 3000,
            ],
        ]);
    }
    $num = $items->count();
    $rate = 1;
    foreach ($gongshi as $key => $value) {
        $rate = $value['min'] <= $num ? $value['rate'] : $rate;
    }
    return $rateNeed ? $rate : $items->sum('amount') * $rate;
}

function refund($ori_items, $tkN)
{

    // 退课目标
    $items = $ori_items->take($tkN);
    $already_amount = 0;
    $rate = sale_price($ori_items, true);

    $ori_items->each(function ($it, $k) use (&$already_amount, $rate) {
        $already_amount += $rate * $it['already'] * $it['amount'] / $it['count'];
    });
    // 剩下的课
    $now_items = $ori_items->slice($tkN);
    // 原收入
    $ori = sale_price($ori_items);
    // 仍然要缴的原费用
    $still_amount = 0;
    // 实际需要的原始费用
    $now_rate = sale_price($now_items, true);
    $now_items->each(function ($it2) use (&$still_amount, $now_rate) {
        $fee = $now_rate * ($it2['count'] - $it2['already']) * $it2['amount'] / $it2['count'];
        $still_amount += $fee;
    });
    $refund = $ori - $still_amount - $already_amount;
}
function downUrl($path)
{
    return '/' . $path;
    // return url($path);
}

function exportToCsv($fileName = '', $headArr = [], $data = [])
{
    //文件夹
    $filedir = public_path("export/csv/");
    if (!is_dir($filedir)) {
        mkdir($filedir, 777, true);
    }

    //路径
    $fileName .= '.csv';
    $filePath = $filedir . $fileName;

    //生成csv文件
    $fp = fopen($filePath, 'w');
    // $fields[$k] = iconv("UTF-8", "GB2312//IGNORE", $v);  // 这里将UTF-8转为GB2312编码

    $header = implode(',', $headArr) . PHP_EOL;
    $content = '';
    foreach ($data as $line => $val) {
        $content .= implode(',', $val) . PHP_EOL;
    }
    $csv = iconv("UTF-8", "GB2312//IGNORE", $header . $content);
    // 强制转码
    // 写入数据
    fwrite($fp, $csv);
    //关闭文件句柄
    fclose($fp);
    return;
}
#生成一个csv，header不能重写
function exportToExcel($fileName = '', $headArr = [], $data = [])
{
    ini_set('memory_limit', '1024M'); //设置程序运行的内存
    ini_set('max_execution_time', 0); //设置程序的执行时间,0为无上限
    @ob_end_clean(); //清除内存
    ob_start();
    @header("Content-Type: text/csv");
    @header("Content-Disposition:filename=" . $fileName . '.csv');
    $fp = fopen('php://output', 'w');
    fwrite($fp, chr(0xEF) . chr(0xBB) . chr(0xBF));
    fputcsv($fp, $headArr);
    $index = 0;
    foreach ($data as $item) {
        if ($index == 1000) {
            //每次写入1000条数据清除内存
            $index = 0;
            ob_flush(); //清除内存
            flush();
        }
        $index++;
        fputcsv($fp, $item);
    }

    @ob_flush();
    flush();
    ob_end_clean();
    return;
}
