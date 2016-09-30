## 小z图床
之前用贴图库API写的图床请访问：[https://github.com/helloxz/tietu](https://github.com/helloxz/tietu)，由于最近贴图库对相关政策做了调整，导致免费用户只能保存最近6个月的图片，于是干脆把代码修改了下，将图片保存在自己本地服务器。

网上找了很多图床程序，功能比较强大，但我却用不到那么多功能，于是写了小z图床方便自己使用。

---

### 相关说明
* 后端使用PHP开发，仅一个单文件<code>upload.php</code>，代码非常的简单，也只有纯粹的图片上传功能
* 使用Ajax异步上传，因此您不用每次都去刷新页面
* 上传成功后会自动生成HTML和Markdown链接，方便使用
* 后期可能会增加图片管理和水印功能

### 使用说明
1. 直接将源码放到您站点的某个目录
2. 修改一下<code>upload.php</code>这个文件，在53行附近，填写您自己的域名
3. 最后访问您的域名测试

![](https://img.bsdev.cn/uploads/1609/0134212181.png)

### 其他说明
* 演示地址：[https://img.bsdev.cn/](https://img.bsdev.cn/ "https://img.bsdev.cn/")
* 个人博客：[https://www.xiaoz.me/](https://www.xiaoz.me/ "https://www.xiaoz.me/")
* QQ:337003006

![](https://img.bsdev.cn/uploads/1609/0138055958.png)