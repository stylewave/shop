<!doctype html>
<html>
<head>{include file ='library/admin_html_head.lbi'}</head>

<body class="iframe_body">
	<div class="warpper">
    	<div class="title"><a href="{$action_link2.href}" class="s-back">{$lang.back}</a>企业 - {$ur_here}</div>
        <div class="content">
        	<div class="tabs_info">
            	<ul>
                    <li class="curr"><a href="javascript:;">添加企业</a></li>
                    <li ><a href="{$action_link.href}">{$action_link.text}</a></li>
				</ul>
            </div>	
        	<div class="explanation" id="explanation">
            	<div class="ex_tit"><i class="sc_icon"></i><h4>操作提示</h4><span id="explanationZoom" title="收起提示"></span></div>
                <ul>
                    <li>可从管理平台手动添加一名新企业，并填写相关信息。</li>
                    <li>标识“<em>*</em>”的选项为必填项，其余为选填项。</li> 
                </ul>
            </div>
            <div class="flexilist">
                <div class="common-content">
                    <div class="mian-info">
                        <form method="post" action="users.php" name="theForm" id="user_form" >
                            <div class="switch_info">
                                <div class="item">
                                    <div class="label">{$lang.require_field}&nbsp;{$lang.code}：</div>
                                    <div class="label_value">
                                        <input type="text" id="code" name="code" class="text" value="" autocomplete="off" />
                                        <div class="form_prompt"></div>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="label">{$lang.require_field}&nbsp;{$lang.companyName}：</div>
                                    <div class="label_value">
                                        <input type="text" name="companyName" class="text" value="" id="companyName" autocomplete="off" />
                                        <div class="form_prompt"></div>
                                    </div>
                                </div> 
                                   <div class="item">
                                    <div class="label">{$lang.require_field}&nbsp;{$lang.je}：</div>
                                    <div class="label_value">
                                        <input type="text" name="je" class="text" value="" id="je" autocomplete="off" />
                                        <div class="form_prompt"></div>
                                    </div>
                                </div> 
                                {foreach from=$extend_info_list item=field}
                                <!-- {if $field.id eq 6} -->
                                  <div class="item">
                                    <div class="label">{$lang.passwd_question}：</div>
                                    <div class="label_value">
                                        <div id="user_sel_question" class="imitate_select select_w320">
                                          <div class="cite">{$lang.sel_question}</div>
                                          <ul>
                                             {foreach from=$passwd_questions item=item key=k}
                                             <li><a href="javascript:;" data-value="{$k}" class="ftx-01">{$item}</a></li>
                                             {/foreach}
                                          </ul>
                                          <input name="sel_question" type="hidden" value="0" id="sel_question">
                                        </div>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="label" {if $field.is_need}id="passwd_quesetion"{/if}>{$lang.passwd_answer}：</div>
                                    <div class="label_value"><input type="text" name="passwd_answer" class="text" value="" autocomplete="off" />&nbsp;{if $field.is_need}{$lang.require_field}{/if}</div>
                                </div>
                                <!-- {else} -->
                                <div class="item">
                                    <div class="label">{$field.reg_field_name}：</div>
                                    <div class="label_value"><input type="text" name="extend_field{$field.id}" class="text" value="" autocomplete="off" /></div>
                                </div>
                                <!--{/if}-->
                                {/foreach}
                                
                                <div class="item">
                                    <div class="label">&nbsp;</div>
                                    <div class="label_value info_btn">
                                        <a href="javascript:;" class="button" id="submitBtn">{$lang.button_submit}</a>
                                        <input type="hidden" name="act" value="{$form_action}" />
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
		</div>
    </div>
 {include file ='library/pagefooter.lbi'}
    <script type="text/javascript">
		//表单验证
		$(function(){
			$("#submitBtn").click(function(){
				if($("#user_form").valid()){
						$("#user_form").submit();
				}
			});
		
			$('#user_form').validate({
				errorPlacement:function(error, element){
					var error_div = element.parents('div.label_value').find('div.form_prompt');
					element.parents('div.label_value').find(".notic").hide();
					error_div.append(error);
				},
				rules : {
					username : {
							required : true
					},
					email : {
							required : true,
							email : true
					},
					password : {
							required : true,
							minlength:6
					},
					confirm_password : {
							required : true,
							equalTo:"#password"
					}
						
				},
				messages : {
					username : {
							required : '<i class="icon icon-exclamation-sign"></i>'+no_username
					},
					email : {
							required : '<i class="icon icon-exclamation-sign"></i>email不能为空',
							email : '<i class="icon icon-exclamation-sign"></i>'+invalid_email
					},
					password : {
							required : '<i class="icon icon-exclamation-sign"></i>'+no_password,
							minlength : '<i class="icon icon-exclamation-sign"></i>'+less_password
					},
					confirm_password : {
							required : '<i class="icon icon-exclamation-sign"></i>'+no_confirm_password,
							equalTo:'<i class="icon icon-exclamation-sign"></i>'+password_not_same
					}
				}
			});
		});
    </script>     
</body>
</html>