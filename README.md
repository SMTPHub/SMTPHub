# SMTPHub 程江统一邮件发送管理系统

简体中文 | [English](./README.md)

## 项目简介

SMTPHub 是一款基于 PHP 语言开发的 SMTP 服务管理和邮件发送系统，类似于邮件推送 API 服务，可实现同一个 SMTP 接口对接多个业务站点，多个业务站点可以统一调用本系统接口实现邮件发送。

支持多个 SMTP 的管理，通过接口 AppSecret 的验证防止非法使用，自动记录每一个邮件发送内容以便审查。帮助企业实现所有站点、app 等产品发送邮件的统一调用和规范管理。

将 SMTP 的调用集中在同一个系统可以防止触发 SMTP 异地登录事件，避免第三方邮箱提供方检测到异常登录可能导致的发送失败的问题。

**主要功能**：

1. 站点、管理员配置
2. SMTP 管理：服务器、端口、账号、密码
3. 应用管理：应用添加/编辑，支持接入站点、App 和服务器，和 AppSecret 管理
4. 发送记录管理：应用信息、发送时间、发送方、接收方、发送内容、状态

**演示地址**：

[http://smtphub.usite.pub/](http://smtphub.usite.pub/)，账号 admin，密码 123456

**预览截图**：

![程江统一邮件发送管理系统](assets/20230605-211342@2x.png)

## 部署方法

- 运行环境要求 PHP5.4+，MySQL5.6+
- 将 `src` 目录内文件全部上传到网站运行目录
- 访问网站，会自动跳转到安装页面，根据提示填写配置信息，进行安装
- 安装完成后，访问 /admin 进入后台管理

## 使用方法：

1. 系统后台【 SMTP 管理】添加 SMTP 服务器配置，依次填写名称、SMTP 主机、端口、账号、密码
2. 系统后台【应用管理】添加应用，填写应用名称，应用密钥，服务类别选中上一步添加的 SMTP 服务，点击【保存】，在列表中点击【密钥】得到 APPSECRET，
3. 使用以上操作拿到的 APPID 和 APPSECRET 调用接口开始使用。

接口调用说明

接口 URL：`http://smtphub.company.com/api.php`

传输方式：HTTP POST

数据格式：JSON 或 FormData

字符编码：UTF-8

POST 参数说明

| 参数名     | 必要 | 示例                             | 说明                                                         |
| ---------- | ---- | -------------------------------- | ------------------------------------------------------------ |
| action     | 必须 | send                             | 发送邮件                                                     |
| appid      | 必须 | 1000                             | 应用ID                                                       |
| appsecret  | 必须 | Cd2DBg2R0JuXgLsrkXb6AfLXV8kW8p4k | 应用密钥                                                     |
| to         | 必须 | username@email-server.com        | 收件人地址                                                   |
| subject    | 必须 | 网站通知                         | 邮件主题                                                     |
| message    | 必须 | `<p>您好，感谢您加入会员 ！</p>` | 邮件内容，支持 HTML                                          |
| to_name    | 可选 | 【网站会员】                     | 收信人名称                                                   |
| from_name  | 可选 | 【站点名称】                     | 发信人名称，未设置时，按照应用配置的【发信人名称】来显示， 若未配置则显示为配置的【应用名称】 |
| reply_to   | 可选 | service@email-server.com         | 回信地址                                                     |
| reply_name | 可选 | 【客户服务部】                   | 回信地址名称（当设置回信地址时才生效），未设置时，替换为发信人名称 |

注意：邮件正文使用 HTML 的，需要 encode 对邮件正文编码后再提交，

JS 中使用 encodeURIComponent()

PHP 中使用 urlencode()

接口请求 JSON 示例

```json
{
    "appid"      : 1000,
    "appsecret"  : "Cd2DBg2R0JuXgLsrkXb6AfLXV8kW8p4k",
    "action"     : "send",
    "to"         : "username@email-server.com",
    "subject"    : "网站通知",
    "message"    : "<p>您好，感谢您加入会员 ！支持HTML！</p>",
    "to_name"    : "【网站会员】",
    "from_name"  : "【站点名称】",
    "reply_to"   : "service@email-server.com",
    "reply_name" : "【客户服务部】"
}
```

接口返回状态：发送成功

```json
{
  "code": 0,
  "msg": "发送成功"
}
```

接口返回状态：发送失败

```json
{
  "code": -1,
  "msg": "发送失败"
}
```

## 问题反馈

请到 [Issues](https://github.com/SMTPHub/SMTPHub/issues) 提交问题。

## 开源许可

SMTPHub 采用 [BSD](./LICENSE) 许可发布。

## 作者

[Jackson Dou](https://github.com/jksdou 'Jackson Dou')

## 版权信息

版权所有 Copyright © 2023-present [CROGRAM](https://crogram.com)
