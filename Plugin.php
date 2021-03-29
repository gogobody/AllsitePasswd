<?php
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
/**
 * AllsitePasswd 是一款启用全站密码访问插件，支持自定义主题模板
 * 
 * @package AllsitePasswd
 * @author 即刻学术
 * @version 1.0.0
 * @link https://www.ijkxs.com
 */
class AllsitePasswd_Plugin implements Typecho_Plugin_Interface
{
    /**
     * 激活插件方法,如果激活失败,直接抛出异常
     * 
     * @access public
     * @return void
     * @throws Typecho_Plugin_Exception
     */
    public static function activate()
    {
        Typecho_Plugin::factory('admin/menu.php')->navBar = array('AllsitePasswd_Plugin', 'render');


//        Typecho_Plugin::factory('index.php')->begin = array('AllsitePasswd_Plugin', 'main_fun');
		Typecho_Plugin::factory('Widget_Archive')->headerOptions =array('AllsitePasswd_Plugin', 'main_fun');
	
	
	
    }

	public static function main_fun()
    {
        Typecho_Widget::widget('Widget_Security')->to($security);
        if ($security->request->get('_') == $security->getToken($security->request->getReferer())){
            return;
        }
        $Str_Msg_PSWERR="";
		//检查密码 处理 cookies
		if ( isset($_POST['index_passwd']) ){
			
			if ( trim($_POST['index_passwd'])==  Typecho_Widget::widget('Widget_Options')->plugin('AllsitePasswd')->str_Pword  ){
				
				setcookie("index_passwd",trim($_POST['index_passwd']),time()+3600*24*7);
	
				echo '<meta http-equiv="refresh" content="0;url='.$_SERVER["REQUEST_URI"].'"> ';
			}else{
				$Str_Msg_PSWERR="密码错误，请重新输入";
			}
		}
		$plugin_optiosn = Typecho_Widget::widget('Widget_Options')->plugin('AllsitePasswd');
		if(empty($_COOKIE["index_passwd"]) or trim($_POST['index_passwd'])!= Typecho_Widget::widget('Widget_Options')->plugin('AllsitePasswd')->str_Pword){
            $html = file_get_contents(dirname(__FILE__) . '/theme/index.html');
            // 替换内容
            $template = str_replace(
                array(
                    '{theme_base_path}',
                    '{str_word}',
                    '{url_pic}',
                    '{err_msg}',
                    '{form_action}',
                    '{input_placeholder}',
                    '{submit_text}',
                    '{commic_pic}'
                ),
                array(
                    Typecho_Common::url('AllsitePasswd/theme/', Helper::options()->pluginUrl),
                    trim($plugin_optiosn->str_word),
                    trim($plugin_optiosn->url_pic),
                    trim($Str_Msg_PSWERR),
                    trim($_SERVER["REQUEST_URI"]),
                    trim($plugin_optiosn->placeholder),
                    trim($plugin_optiosn->Submit),
                    'https://cloud.qqshabi.cn/api/images/api.php'
                ),
                $html
            );
            die($template);
     ?>
<!--	 <!DOCTYPE html><html lang="en"><head><meta charset="UTF-8">-->
<!--        <title>--><?php //echo htmlspecialchars(Typecho_Widget::widget('Widget_Options')->plugin('AllsitePasswd')->str_word)?><!--</title>-->
<!--        <style>html {padding: 50px 10px;font-size: 16px;line-height: 1.4;color: #666;background: #F6F6F3;-webkit-text-size-adjust: 100%;                -ms-text-size-adjust: 100%;}html,input { font-family: "Helvetica Neue", Helvetica, Arial, sans-serif; }body {max-width: 500px;_width: 500px;padding: 30px 20px;margin: 0 auto;background: #FFF;}ul {padding: 0 0 0 40px;}.container {max-width: 380px;_width: 380px;margin: 0 auto;}</style>-->
<!--    </head><body>-->
<!--        <div class="container">-->
<!--        <img src=" --><?php //echo htmlspecialchars(Typecho_Widget::widget('Widget_Options')->plugin('AllsitePasswd')->url_pic)?><!--" />-->
<!--        <br>-->
<!--           --><?php //echo Typecho_Widget::widget('Widget_Options')->plugin('AllsitePasswd')->str_word?>
<!--           <br><span style="color:red">--><?php //echo $Str_Msg_PSWERR;?><!--</span><br>-->
<!---->
<!--           <form action="--><?php //echo $_SERVER["REQUEST_URI"];?><!--" method="post" >-->
<!--           <input type="password"  name="index_passwd" placeholder="--><?php //echo htmlspecialchars(Typecho_Widget::widget('Widget_Options')->plugin('AllsitePasswd')->placeholder)?><!--" /> -->
<!--           -->
<!--           <input type="submit" value="--><?php //echo htmlspecialchars(Typecho_Widget::widget('Widget_Options')->plugin('AllsitePasswd')->Submit)?><!--">-->
<!--           </form>-->
<!--        </div>-->
<!--        </body></html>-->
	 <?php
	 //停止输出其他内容
	 exit();
	 
	 }else{
		//密码存在 什么都不做
	}	
	 
	 
	}
	
	
	
    /**
     * 禁用插件方法,如果禁用失败,直接抛出异常
     * 
     * @static
     * @access public
     * @return void
     * @throws Typecho_Plugin_Exception
     */
    public static function deactivate(){}
    
    /**
     * 获取插件配置面板
     * 
     * @access public
     * @param Typecho_Widget_Helper_Form $form 配置面板
     * @return void
     */
    public static function config(Typecho_Widget_Helper_Form $form)
    {
        /** 分类名称 */
        $str_word = new Typecho_Widget_Helper_Form_Element_Text('str_word', NULL, '网站已经启用全站加密，请输入密码访问', _t('提示文字'));
        $form->addInput($str_word);
		
		
		$placeholder = new Typecho_Widget_Helper_Form_Element_Text('placeholder', NULL, '输入密码查看精彩内容', _t('输入框提示'));
        $form->addInput($placeholder);
		
		
		$Submit = new Typecho_Widget_Helper_Form_Element_Text('Submit', NULL, '提交', _t('Submit按钮提示'));
        $form->addInput($Submit);
		
		$url_pic = new Typecho_Widget_Helper_Form_Element_Text('url_pic', NULL, 'http://typecho.org/usr/themes/bluecode/img/typecho-logo.svg', _t('提示图片'));
        $form->addInput($url_pic);
		
		$str_Pword = new Typecho_Widget_Helper_Form_Element_Text('str_Pword', NULL, '123456',_t('设置全站访问密码'));
        $form->addInput($str_Pword);
			
		//$enable_in_html = new Typecho_Widget_Helper_Form_Element_Radio('enable_in_html', array ('0' => '加密后内容依旧可以在html和搜索引擎中可见', '1' => '彻底隐藏数据'), '0',        '是否完全隐藏内容：', '');
   // $form->addInput($enable_in_html);
    }
    
    /**
     * 个人用户的配置面板
     * 
     * @access public
     * @param Typecho_Widget_Helper_Form $form
     * @return void
     */
    public static function personalConfig(Typecho_Widget_Helper_Form $form){}
    
    /**
     * 插件实现方法
     * 
     * @access public
     * @return void
     */
    public static function render()
    {
        echo '<a href="options-plugin.php?config=AllsitePasswd">全站密码</a>';
    }
	
	
	
}
