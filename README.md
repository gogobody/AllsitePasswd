# AllsitePasswd
AllsitePasswd 是一款启用全站密码访问插件，支持自定义主题模板:@(呆滞)

github地址：https://github.com/gogobody/AllsitePasswd

欢迎 fork，start

![](https://cdn.jsdelivr.net/gh/gogobody/blog-img/blogimg/20210311203610.png)

## 说明
插件默认自带一套模板

用户可以自定义模板，把你的html模板文件放进theme文件夹，html起名叫index.html

但注意引用图片，css，js等文件时需要使用绝对路径。
比如：
-AllsitePasswd  
|- theme  
&nbsp;&nbsp;   |- css/a.css  
&nbsp;&nbsp;   |- js/b.js  
&nbsp;&nbsp;  |- index.html

这个时候 index.html 里面引入a.css的路径为
```css
/usr/plugins/AllsitePasswd/theme/css/a.css
```
同样引入 js 路径为
```css
/usr/plugins/AllsitePasswd/theme/js/b.js
```

在 html 文件中可以用的替代变量，只需要把html对应位置换成以下变量即可。只针对 index.html 有效:@(鼓掌)。

```css
'{theme_base_path}',// 绝对路径，指向 /usr/plugins/AllsitePasswd/theme/
'{str_word}', // 后台配置的提示文字
'{url_pic}', // 后台配置的提示图片
'{err_msg}',// 密码错误输出消息
'{form_action}',// form表单提交的 url ，也就是 action='{form_action}'
'{input_placeholder}',// 后台配置的输入框提示
'{submit_text}',// 后台配置的提交按钮
'{commic_pic}' // 插件自带的动漫图 api，比如：<img src="{commic_pic}">
```
还有就是输入密码那个 input 的name属性：
```css
name="index_passwd"
```

举个栗子:&(蛆音疑惑)：
```
<form action="{form_action}">
<input name="index_passwd" type="password" placeholder="{input_placeholder}" />
<input type="submit" value="{submit_text}">
</form>

```