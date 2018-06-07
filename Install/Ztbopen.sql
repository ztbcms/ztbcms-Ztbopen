CREATE TABLE `cms_ztbopen_applications` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) NOT NULL DEFAULT '' COMMENT 'ztbopen应用名称',
  `app_id` varchar(32) NOT NULL DEFAULT '' COMMENT 'app_id',
  `app_secret` varchar(32) NOT NULL DEFAULT '' COMMENT '应用秘钥',
  `create_time` int(10) DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) DEFAULT '0' COMMENT '更新时间',
  `is_default` tinyint(2) DEFAULT '0' COMMENT '是否默认',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `cms_ztbopen_wechat` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL DEFAULT '0',
  `subscribe` tinyint(1) NOT NULL COMMENT '是否关注',
  `sex` int(11) NOT NULL COMMENT '性别',
  `openid` varchar(64) NOT NULL DEFAULT '' COMMENT 'openid',
  `city` varchar(128) NOT NULL DEFAULT '' COMMENT '所属城市',
  `province` varchar(128) NOT NULL DEFAULT '' COMMENT '所属城市',
  `country` varchar(128) NOT NULL DEFAULT '' COMMENT '所属国家',
  `headimgurl` varchar(512) NOT NULL DEFAULT '' COMMENT '微信头像',
  `nickname` varchar(32) NOT NULL DEFAULT '' COMMENT '微信昵称',
  `language` varchar(32) NOT NULL DEFAULT '' COMMENT '所用语言',
  `subscribe_time` varchar(64) NOT NULL COMMENT '关注时间',
  `remark` varchar(255) NOT NULL DEFAULT '' COMMENT '备注',
  `privilege` varchar(255) NOT NULL DEFAULT '' COMMENT '特权信息',
  `authorizer_appid` varchar(255) NOT NULL DEFAULT '' COMMENT '开放平台app_id',
  `groupid` varchar(64) NOT NULL DEFAULT '' COMMENT '用户所在的分组',
  `tagid_list` varchar(64) NOT NULL DEFAULT '' COMMENT '标签ID列表',
  `unionid` varchar(64) NOT NULL DEFAULT '' COMMENT 'unionid',
  `app_id` varchar(64) NOT NULL DEFAULT '' COMMENT '应用ID',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `cms_ztbopen_wechat_template` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `app_id` varchar(128) DEFAULT NULL COMMENT 'app_id',
  `name` varchar(64) NOT NULL COMMENT '英文名',
  `template_id` varchar(64) NOT NULL DEFAULT '' COMMENT '模板ID',
  `title` varchar(128) NOT NULL DEFAULT '' COMMENT '标题',
  `description` varchar(512) NOT NULL DEFAULT '' COMMENT '描述',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `cms_ztbopen_wechat_pay_order` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `return_code` varchar(255) DEFAULT NULL COMMENT '调用结果',
  `return_msg` varchar(255) DEFAULT NULL COMMENT '调用信息',
  `appid` varchar(128) DEFAULT NULL COMMENT 'app_id',
  `mch_id` varchar(128) DEFAULT NULL COMMENT '商户id',
  `nonce_str` varchar(32) DEFAULT NULL COMMENT '随机码',
  `sign` varchar(255) DEFAULT NULL COMMENT '签名',
  `result_code` varchar(255) DEFAULT NULL COMMENT '业务代码',
  `openid` varchar(255) DEFAULT NULL COMMENT '用户openid',
  `is_subscribe` varchar(16) DEFAULT NULL COMMENT '是否关注',
  `trade_type` varchar(32) DEFAULT NULL COMMENT '交易类型',
  `bank_type` varchar(32) DEFAULT NULL COMMENT '银行',
  `total_fee` int(11) DEFAULT NULL COMMENT '交易总额',
  `fee_type` varchar(255) DEFAULT NULL COMMENT '钱币类型',
  `transaction_id` varchar(255) DEFAULT NULL COMMENT '流水号',
  `out_trade_no` varchar(255) DEFAULT NULL COMMENT '订单号',
  `attach` varchar(255) DEFAULT NULL COMMENT '附加值',
  `time_end` varchar(128) DEFAULT NULL COMMENT '结束时间',
  `trade_state` varchar(255) DEFAULT NULL COMMENT '交易状态',
  `trade_state_desc` varchar(255) DEFAULT NULL COMMENT '交易解释',
  `cash_fee` int(11) DEFAULT NULL COMMENT '现金金额（不知道是什么）',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `cms_ztbopen_wechat_refund_order` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `return_code` varchar(255) NOT NULL COMMENT '调用结果',
  `return_msg` varchar(255) NOT NULL COMMENT '调用信息',
  `appid` varchar(255) NOT NULL COMMENT 'app_id',
  `mch_id` varchar(255) NOT NULL COMMENT '商户id',
  `nonce_str` varchar(255) NOT NULL COMMENT '随机码',
  `sign` varchar(255) NOT NULL COMMENT '签名',
  `result_code` varchar(255) NOT NULL COMMENT '业务代码',
  `err_code_des` varchar(255) NOT NULL COMMENT '错误信息',
  `transaction_id` varchar(255) NOT NULL COMMENT '流水号',
  `out_trade_no` varchar(255) NOT NULL COMMENT '订单号',
  `out_refund_no` varchar(255) NOT NULL COMMENT '退款订单号',
  `refund_id` varchar(255) NOT NULL,
  `refund_fee` varchar(255) NOT NULL COMMENT '退款金额',
  `coupon_refund_fee` varchar(255) NOT NULL,
  `total_fee` varchar(255) NOT NULL COMMENT '交易总额',
  `cash_fee` varchar(255) NOT NULL,
  `coupon_refund_count` varchar(255) NOT NULL,
  `cash_refund_fee` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;