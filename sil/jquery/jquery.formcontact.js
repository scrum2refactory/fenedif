(jQuery.fn.formContact=function(options){var defaults={formid:'form-contact',event:'click',animation:{"height":"toggle","opacity":"toggle"},validate:true,duration:"slow",succes:function(){alert('Mensaje enviado')},error:function(){alert('El mensaje no pudo ser enviado')},opacity:0.75,overlaycolor:"#000",close:''};var opts=$.extend(defaults,options);var $elementa=this;var $elementform=$("#"+opts.formid);var $overlay;var $validator;var $load;init();function center(el){var containerHeight=$(el).height();var containerWidth=$(el).width();var windowWidth=$(window).width();var windowHeight=$(window).height();$(el).css({"position":"absolute","left":windowWidth/2-containerWidth/2,"top":windowHeight/2-containerHeight/2,"z-index":102})};function displayOverlay(){$overlay=$('<div />').css({'height':'100%','left':'0','position':'fixed','width':'100%','top':'0','z-index':'100','background-color':opts.overlaycolor,'opacity':opts.opacity}).appendTo("body")};function displayForm(type){switch(type){case"show":displayOverlay();$elementform.animate(opts.animation,{duration:opts.duration});break;case"hide":$("#"+opts.formid+" input[type='text']").val("");if(opts.validate)$validator.resetForm();$elementform.hide();$overlay.remove();break}};function elementClose(){var el;if(opts.close!=""){el=$("#"+opts.close)}else{el=$('<div><span>X</span></div>').css({'position':'absolute','margin-top':'0px','top':'0px','width':'95%','text-align':'right','cursor':'pointer'}).appendTo($elementform)}return el}function displayLoad(){$load=$("<div class='load'></div>");$load.appendTo($elementform).css({'position':'static','text-align':'center','width':'100%','height':'20px'})}function closeLoad(){$load.remove()}function init(){$(window).bind("resize",function(){center($elementform)});elementClose().bind('click',function(){displayForm("hide")});$elementform.hide();center($elementform);$elementa.bind(opts.event,function(){displayForm("show")});if(opts.validate){$validator=$elementform.validate({submitHandler:function(form){displayLoad();$.post($(this).attr('action'),$(this).serialize(),function(data){if(data=="ok")opts.succes();else opts.error();$load.remove();displayForm('hide')})}})}else{$elementform.submit(function(){displayLoad();$.post($elementform.attr('action'),$elementform.serialize(),function(data){if(data=="ok")opts.succes();else opts.error();$load.remove();displayForm('hide')});return false})}}});