UE.Editor.prototype.placeholder = function (PlaceText) {
	var TheText = this;
	TheText.addListener("focus", function () {
		var PHtml = TheText.getContent();
		if(PHtml == PlaceText){
			TheText.setContent(' ');
		}
	});
	TheText.addListener("blur", function(){
	var PHtml = TheText.getContent();
		if(!PHtml){
			TheText.setContent(PlaceText);
		}
	});
	TheText.ready(function(){
		if(PlaceText){
			TheText.setContent(PlaceText);
		}
	});
};
function ueditor_init(obj){
	var textarea = obj.getElementsByTagName('textarea');
	for(var t=0;t<textarea.length;t++){
		if(textarea[t].hasAttribute('ueditor')) {
			rand = Math.ceil((Math.random()*100000));
			textarea[t].id = 'ueditor'+rand;
			if(textarea[t].hasAttribute('width')) {
				uewidth = textarea[t].getAttribute('width');
			}else{
				uewidth = '100%';
			}
			if(textarea[t].hasAttribute('height')) {
				ueheight = textarea[t].getAttribute('height');
			}else{
				ueheight = 400;
			}
			(function(ue, id, $){
				ue.addListener('contentChange',function(){
					$('#'+id).next('textarea[name]').val( ue.getContent() ).change();
				});
			})(
				UE.getEditor('ueditor'+rand,{
					initialFrameHeight: ueheight,
					initialFrameWidth: uewidth
				}),
				'ueditor'+rand,
				$
			);
		}
	}
}
ueditor_init(document);