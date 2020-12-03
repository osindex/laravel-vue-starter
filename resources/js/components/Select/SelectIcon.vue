<template>
  <div>
    <el-popover
      v-if="inputType || disabledSelected"
      v-model="popoverVisible"
      placement="bottom-start"
      popper-class="pupop-select-icon"
      transition="el-zoom-in-top"
      trigger="click"
      :disabled="disabledSelected"
    >
      <!-- 弹出框内容区 -->
      <el-scrollbar
        v-if="popoverVisible"
        class="hide-x"
        :native="false"
        :noresize="false"
      >
        <!-- 图标项 -->
        <el-tabs tab-position="left">
            <el-tab-pane
              v-for="items in options"
              :key="items.title"
              :label="items.title">
              <div
                v-for="item in items.icon"
                :key="item"
                class="icon-item"
                :class="{ 'is-active': isActive(item) }"
                @click="onClickSelected(item)"
              >
                <i :class="item" />
              </div>
            </el-tab-pane>
        </el-tabs>
      </el-scrollbar>
      <!-- 页面显示内容区 -->
      <template slot="reference">
        <div
          :class="{
            'mod-select-icon': 1,
            'is-opened': popoverVisible,
            'is-active': value,
            'is-disabled': disabledSelected
          }"
        >
          <!-- 显示图标 -->
          <div class="icon-item">
            <i :class="value || 'el-icon-plus'" />
          </div>
          <!-- 清空按钮 -->
          <div v-show="value" class="btn-clear">
            <i class="el-icon-close" @click.stop="onClickClear()" />
          </div>
        </div>
      </template>
    </el-popover>
    <el-input v-else v-model.trim="textIcon" class="mod-input" @change="onClickSelected" />
    <el-button :disabled="disabledSelected" :type="inputType?'primary':'ghost'" icon="el-icon-edit" circle @click="inputType = !inputType" />
  </div>
</template>

<script>
export default {
  name: 'SelectIcon',
  // 设置绑定参数
  model: {
    prop: 'value',
    event: 'selected'
  },
  props: {
    disabled: Boolean,
    // 接收绑定参数 - 图标类名
    value: {
      type: String,
      required: false
    },
    // 选项数据，图标类名数组
    options: {
      type: Array,
      default: () => (
        [  
            {
              title: '阿里云图标',
              icon: [
                'icon adminicon logout','icon adminicon blank','icon adminicon qrcode','icon adminicon check','icon adminicon eye','icon adminicon lock','icon adminicon loading','icon adminicon weixin','icon adminicon icon-test151','icon adminicon icon-test152','icon adminicon icon-test153','icon adminicon icon-test154','icon adminicon icon-test155','icon adminicon icon-test156','icon adminicon icon-test157','icon adminicon icon-test158','icon adminicon icon-test159','icon adminicon icon-test160','icon adminicon icon-test161','icon adminicon icon-test162','icon adminicon icon-test163','icon adminicon icon-test164','icon adminicon icon-test165','icon adminicon icon-organization','icon adminicon icon-balance','icon adminicon icon-book-data','icon adminicon icon-flag','icon adminicon icon-dollar','icon adminicon icon-card','icon adminicon icon-test172','icon adminicon icon-set','icon adminicon icon-circle','icon adminicon icon-book','icon adminicon icon-cut','icon adminicon icon-judge','icon adminicon icon-print','icon adminicon icon-change','icon adminicon icon-test','icon adminicon icon-test1','icon adminicon icon-test2','icon adminicon icon-test3','icon adminicon icon-test4','icon adminicon icon-test5','icon adminicon icon-test6','icon adminicon icon-test7','icon adminicon icon-test8','icon adminicon icon-test9','icon adminicon icon-test10','icon adminicon icon-test11','icon adminicon icon-test12','icon adminicon icon-test13','icon adminicon icon-test14','icon adminicon icon-test15','icon adminicon icon-test16','icon adminicon icon-test17','icon adminicon icon-test18','icon adminicon icon-test19','icon adminicon icon-test20','icon adminicon icon-test21','icon adminicon icon-test22','icon adminicon icon-test23','icon adminicon icon-test24','icon adminicon icon-test25','icon adminicon icon-test26','icon adminicon icon-test27','icon adminicon icon-test28','icon adminicon icon-test29','icon adminicon icon-test30','icon adminicon icon-test31','icon adminicon icon-test32','icon adminicon icon-test33','icon adminicon icon-test34','icon adminicon icon-test35','icon adminicon icon-test36','icon adminicon icon-test37','icon adminicon icon-test38','icon adminicon icon-test39','icon adminicon icon-test40','icon adminicon icon-test41','icon adminicon icon-test42','icon adminicon icon-test43','icon adminicon icon-test44','icon adminicon icon-test45','icon adminicon icon-test46','icon adminicon icon-test47','icon adminicon icon-test48','icon adminicon icon-test49','icon adminicon icon-test50','icon adminicon icon-test51','icon adminicon icon-test52','icon adminicon icon-test53','icon adminicon icon-test54','icon adminicon icon-test55','icon adminicon icon-test56','icon adminicon icon-test57','icon adminicon icon-test58','icon adminicon icon-test59','icon adminicon icon-test60','icon adminicon icon-test61','icon adminicon icon-test62','icon adminicon icon-test63','icon adminicon icon-test64','icon adminicon icon-test65','icon adminicon icon-test66','icon adminicon icon-test67','icon adminicon icon-test68','icon adminicon icon-test69','icon adminicon icon-test70','icon adminicon icon-test71','icon adminicon icon-test72','icon adminicon icon-test73','icon adminicon icon-test74','icon adminicon icon-test75','icon adminicon icon-test76','icon adminicon icon-test77','icon adminicon icon-test78','icon adminicon icon-test79','icon adminicon icon-test80','icon adminicon icon-test81','icon adminicon icon-test82','icon adminicon icon-test83','icon adminicon icon-test84','icon adminicon icon-test85','icon adminicon icon-test86','icon adminicon icon-test87','icon adminicon icon-test88','icon adminicon icon-test89','icon adminicon icon-test90','icon adminicon icon-test91','icon adminicon icon-test92','icon adminicon icon-test93','icon adminicon icon-test94','icon adminicon icon-test95','icon adminicon icon-test96','icon adminicon icon-test97','icon adminicon icon-test98','icon adminicon icon-test99','icon adminicon icon-test100','icon adminicon icon-test101','icon adminicon icon-test102','icon adminicon icon-test103','icon adminicon icon-test104','icon adminicon icon-test105','icon adminicon icon-test106','icon adminicon icon-test107','icon adminicon icon-test108','icon adminicon icon-test109','icon adminicon icon-test110','icon adminicon icon-test111','icon adminicon icon-test112','icon adminicon icon-test113','icon adminicon icon-test114','icon adminicon icon-test115','icon adminicon icon-test116','icon adminicon icon-test117','icon adminicon icon-test118','icon adminicon icon-test119','icon adminicon icon-test120','icon adminicon icon-test121','icon adminicon icon-test122','icon adminicon icon-test123','icon adminicon icon-test124','icon adminicon icon-test125','icon adminicon icon-test126','icon adminicon icon-test127','icon adminicon icon-test128','icon adminicon icon-test129','icon adminicon icon-test130','icon adminicon icon-test131','icon adminicon icon-test132','icon adminicon icon-test133','icon adminicon icon-test134','icon adminicon icon-test135','icon adminicon icon-test136','icon adminicon icon-test137','icon adminicon icon-test138','icon adminicon icon-test139','icon adminicon icon-test140','icon adminicon icon-test141','icon adminicon icon-test142','icon adminicon icon-test143','icon adminicon icon-test144','icon adminicon icon-test145','icon adminicon icon-test146','icon adminicon icon-test147','icon adminicon icon-test148','icon adminicon icon-test149','icon adminicon icon-test150'
              ]
            },
            {
              title: 'UI图标',
              icon:[
                'el-icon-ice-cream-round', 'el-icon-ice-cream-square', 'el-icon-lollipop', 'el-icon-potato-strips', 'el-icon-milk-tea', 'el-icon-ice-drink', 'el-icon-ice-tea', 'el-icon-coffee', 'el-icon-orange', 'el-icon-pear', 'el-icon-apple', 'el-icon-cherry', 'el-icon-watermelon', 'el-icon-grape', 'el-icon-refrigerator', 'el-icon-goblet-square-full', 'el-icon-goblet-square', 'el-icon-goblet-full', 'el-icon-goblet', 'el-icon-cold-drink', 'el-icon-coffee-cup', 'el-icon-water-cup', 'el-icon-hot-water', 'el-icon-ice-cream', 'el-icon-dessert', 'el-icon-sugar', 'el-icon-tableware', 'el-icon-burger', 'el-icon-knife-fork', 'el-icon-fork-spoon', 'el-icon-chicken', 'el-icon-food', 'el-icon-dish-1', 'el-icon-dish', 'el-icon-moon-night', 'el-icon-moon', 'el-icon-cloudy-and-sunny', 'el-icon-partly-cloudy', 'el-icon-cloudy', 'el-icon-sunny', 'el-icon-sunset', 'el-icon-sunrise-1', 'el-icon-sunrise', 'el-icon-heavy-rain', 'el-icon-lightning', 'el-icon-light-rain', 'el-icon-wind-power', 'el-icon-baseball', 'el-icon-soccer', 'el-icon-football', 'el-icon-basketball', 'el-icon-ship', 'el-icon-truck', 'el-icon-bicycle', 'el-icon-mobile-phone', 'el-icon-service', 'el-icon-key', 'el-icon-unlock', 'el-icon-lock', 'el-icon-watch', 'el-icon-watch-1', 'el-icon-timer', 'el-icon-alarm-clock', 'el-icon-map-location', 'el-icon-delete-location', 'el-icon-add-location', 'el-icon-location-information', 'el-icon-location-outline', 'el-icon-location', 'el-icon-place', 'el-icon-discover', 'el-icon-first-aid-kit', 'el-icon-trophy-1', 'el-icon-trophy', 'el-icon-medal', 'el-icon-medal-1', 'el-icon-stopwatch', 'el-icon-mic', 'el-icon-copy-document', 'el-icon-full-screen', 'el-icon-switch-button', 'el-icon-aim', 'el-icon-crop', 'el-icon-odometer', 'el-icon-time', 'el-icon-bangzhu', 'el-icon-close-notification', 'el-icon-microphone', 'el-icon-turn-off-microphone', 'el-icon-position', 'el-icon-postcard', 'el-icon-message', 'el-icon-chat-line-square', 'el-icon-chat-dot-square', 'el-icon-chat-dot-round', 'el-icon-chat-square', 'el-icon-chat-line-round', 'el-icon-chat-round', 'el-icon-set-up', 'el-icon-turn-off', 'el-icon-open', 'el-icon-connection', 'el-icon-link', 'el-icon-cpu', 'el-icon-thumb', 'el-icon-female', 'el-icon-male', 'el-icon-guide', 'el-icon-news', 'el-icon-price-tag', 'el-icon-discount', 'el-icon-wallet', 'el-icon-coin', 'el-icon-money', 'el-icon-bank-card', 'el-icon-box', 'el-icon-present', 'el-icon-sell', 'el-icon-sold-out', 'el-icon-shopping-bag-2', 'el-icon-shopping-bag-1', 'el-icon-shopping-cart-2', 'el-icon-shopping-cart-1', 'el-icon-shopping-cart-full', 'el-icon-smoking', 'el-icon-no-smoking', 'el-icon-house', 'el-icon-table-lamp', 'el-icon-school', 'el-icon-office-building', 'el-icon-toilet-paper', 'el-icon-notebook-2', 'el-icon-notebook-1', 'el-icon-files', 'el-icon-collection', 'el-icon-receiving', 'el-icon-suitcase-1', 'el-icon-suitcase', 'el-icon-film', 'el-icon-collection-tag', 'el-icon-data-analysis', 'el-icon-pie-chart', 'el-icon-data-board', 'el-icon-data-line', 'el-icon-reading', 'el-icon-magic-stick', 'el-icon-coordinate', 'el-icon-mouse', 'el-icon-brush', 'el-icon-headset', 'el-icon-umbrella', 'el-icon-scissors', 'el-icon-mobile', 'el-icon-attract', 'el-icon-monitor', 'el-icon-search', 'el-icon-takeaway-box', 'el-icon-paperclip', 'el-icon-printer', 'el-icon-document-add', 'el-icon-document', 'el-icon-document-checked', 'el-icon-document-copy', 'el-icon-document-delete', 'el-icon-document-remove', 'el-icon-tickets', 'el-icon-folder-checked', 'el-icon-folder-delete', 'el-icon-folder-remove', 'el-icon-folder-add', 'el-icon-folder-opened', 'el-icon-folder', 'el-icon-edit-outline', 'el-icon-edit', 'el-icon-date', 'el-icon-c-scale-to-original', 'el-icon-view', 'el-icon-loading', 'el-icon-rank', 'el-icon-sort-down', 'el-icon-sort-up', 'el-icon-sort', 'el-icon-finished', 'el-icon-refresh-left', 'el-icon-refresh-right', 'el-icon-refresh', 'el-icon-video-play', 'el-icon-video-pause', 'el-icon-d-arrow-right', 'el-icon-d-arrow-left', 'el-icon-arrow-up', 'el-icon-arrow-down', 'el-icon-arrow-right', 'el-icon-arrow-left', 'el-icon-top-right', 'el-icon-top-left', 'el-icon-top', 'el-icon-bottom', 'el-icon-right', 'el-icon-back', 'el-icon-bottom-right', 'el-icon-bottom-left', 'el-icon-caret-top', 'el-icon-caret-bottom', 'el-icon-caret-right', 'el-icon-caret-left', 'el-icon-d-caret', 'el-icon-share', 'el-icon-menu', 'el-icon-s-grid', 'el-icon-s-check', 'el-icon-s-data', 'el-icon-s-opportunity', 'el-icon-s-custom', 'el-icon-s-claim', 'el-icon-s-finance', 'el-icon-s-comment', 'el-icon-s-flag', 'el-icon-s-marketing', 'el-icon-s-shop', 'el-icon-s-open', 'el-icon-s-management', 'el-icon-s-ticket', 'el-icon-s-release', 'el-icon-s-home', 'el-icon-s-promotion', 'el-icon-s-operation', 'el-icon-s-unfold', 'el-icon-s-fold', 'el-icon-s-platform', 'el-icon-s-order', 'el-icon-s-cooperation', 'el-icon-bell', 'el-icon-message-solid', 'el-icon-video-camera', 'el-icon-video-camera-solid', 'el-icon-camera', 'el-icon-camera-solid', 'el-icon-download', 'el-icon-upload2', 'el-icon-upload', 'el-icon-picture-outline-round', 'el-icon-picture-outline', 'el-icon-picture', 'el-icon-close', 'el-icon-check', 'el-icon-plus', 'el-icon-minus', 'el-icon-help', 'el-icon-s-help', 'el-icon-circle-close', 'el-icon-circle-check', 'el-icon-circle-plus-outline', 'el-icon-remove-outline', 'el-icon-zoom-out', 'el-icon-zoom-in', 'el-icon-error', 'el-icon-success', 'el-icon-circle-plus', 'el-icon-remove', 'el-icon-info', 'el-icon-question', 'el-icon-warning-outline', 'el-icon-warning', 'el-icon-goods', 'el-icon-s-goods', 'el-icon-star-off', 'el-icon-star-on', 'el-icon-more-outline', 'el-icon-more', 'el-icon-phone-outline', 'el-icon-phone', 'el-icon-user', 'el-icon-user-solid', 'el-icon-setting', 'el-icon-s-tools', 'el-icon-delete', 'el-icon-delete-solid', 'el-icon-eleme'
              ]
            }
        ]
      )
    }
  },
  data() {
    return {
      // 弹出框显示状态
      popoverVisible: false,
      inputType: true,
      textIcon: this.value
    }
  },
  watch: {
    value(newValue) {
      this.textIcon = newValue
    }
  },
  computed: {
    disabledSelected() {
      if (this.disabled) return true
      return this.$parent.form ? this.$parent.form.disabled : false
    }
  },
  methods: {
    // 是否为当前已选项
    isActive(item) {
      return this.value === item
    },
    // 选中图标
    onClickSelected(item) {
      this.$emit('selected', item)
      this.textIcon = item
      this.popoverVisible = false
    },
    // 清空选项
    onClickClear() {
      this.$emit('selected', '')
    }
  }
}
</script>

<style lang="scss">
@import "../../assets/css/init.scss";
@import "~element-ui/packages/theme-chalk/src/common/var.scss";
.mod-input {
  width: 80%;
}
.mod-select-icon
{
  $size: 40px;
  $col-count: 8;
  $row-count: 4;
  $scope: 5px;

  position: relative;
  display: inline-block;
  width: $size;
  height: $size;
  border: 1px dashed $--border-color-base;
  border-radius: 5px;
  text-align: center;
  cursor: pointer;
  outline: none;

  // 菜单打开状态
  &.is-opened, &:hover { border-color: $--color-primary; }
  // 禁用状态
  &.is-disabled:hover { border-color: $--border-color-base !important; }
  &.is-disabled,
  &.is-disabled > .icon-item,
  &.is-disabled > .btn-clear {
    background-color: $--background-color-base;
  }
  // 已选状态
  &.is-active {
    border-style: solid;
    border-radius: 0;
    > .icon-item {
      padding: $scope;
      text-align: center;
      cursor: pointer;
      > i {
        display: block;
        width: 100%;
        height: 100%;
        line-height: $size - ($scope * 2);
        color: $--color-white;
        background-color: $--color-primary;
      }
    }
  }
  > .icon-item > i { font-size: 16px; }
  > .icon-item > iel-icon-plus {
    width: 100%;
    line-height: $size;
    font-size: ($size / 2);
    font-weight: bold;
    color: $--color-info;
    cursor: inherit;
  }

  // 清空按钮
  .btn-clear {
    width: 0;
    height: 0;
    border-width: ($size / 2) 0 0 ($size / 2);
    border-style: solid;
    border-color: $--color-danger transparent transparent transparent;
    position: absolute;
    top: 0;
    right: 0;
    cursor: pointer;
    > iel-icon-close {
      position: absolute;
      top: -($size / 2);
      right: 0;
      color: $--color-white;
      font-size: .7em;
      &:hover { color: darken($--color-white, 5%); }
    }
  }

  // 弹出内容
  @at-root .el-popover.el-popper.pupop-select-icon {
    display: block;
    padding: 0;
    width: ($size + $scope * 2) * $col-count + 2px;
    height: ($size + $scope * 2) * $row-count;

    > .el-scrollbar { height: 100%; }
    .el-scrollbar__view {
    }

    .icon-item {
      float: left;
      width: $size;
      height: $size;
      line-height: $size;
      margin: $scope;
      padding: $scope;
      text-align: center;
      cursor: pointer;
      &:hover { background-color: $--color-info-light; }
      &.is-active {
        background-color: $--color-success-light;
        border: 1px solid $--color-success;
      }
      > i {
        display: block;
        width: 100%;
        height: 100%;
        font-size: 16px;
        line-height: $size - ($scope * 2);
        color: $--color-white;
        background-color: $--color-primary;
      }
    }
  }
}
</style>
