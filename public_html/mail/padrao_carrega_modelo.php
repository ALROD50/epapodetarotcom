<?php
date_default_timezone_set("Brazil/East"); // seta configurações fusuhorario para Brasil
ini_set ('default_charset', 'UTF-8'); // seta o php em UTF 8
include_once "/home/epapodetarotcom/public_html/includes/conexaoPdo.php";
$pdo=conexao();
$TinyMce="SIM";
$habilitareditor = 'completo';
$cod = $_POST['cod'];
$sql = $pdo->query("SELECT * FROM mail_padrao_modelos WHERE tipo='$cod'"); 
while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
    $modelo=$row['modelo'];
}
?>
<textarea name="modelo" style="height:400px;width:100%;" class="form-control"><?php echo $modelo; ?></textarea>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script src="https://cdn.tiny.cloud/1/rbavzhky4qhsevjecaywqycghd6d7dvhy3iltsxdh077ptwu/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<script>
	tinymce.init({
		selector: 'textarea',
		plugins: 'print preview powerpaste casechange importcss tinydrive searchreplace autolink autosave save directionality advcode visualblocks visualchars fullscreen image link media mediaembed template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists checklist wordcount tinymcespellchecker a11ychecker imagetools textpattern noneditable help formatpainter permanentpen pageembed charmap tinycomments mentions quickbars linkchecker emoticons advtable',
		mobile: {
		plugins: 'print preview powerpaste casechange importcss tinydrive searchreplace autolink autosave save directionality advcode visualblocks visualchars fullscreen image link media mediaembed template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists checklist wordcount tinymcespellchecker a11ychecker textpattern noneditable help formatpainter pageembed charmap mentions quickbars linkchecker emoticons advtable'
		},
		menu: {
		tc: {
		  title: 'TinyComments',
		  items: 'addcomment showcomments deleteallconversations'
		}
		},
		menubar: 'file edit view insert format tools table tc help',
		toolbar: 'undo redo | bold italic underline strikethrough | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist checklist | forecolor backcolor casechange permanentpen formatpainter removeformat | pagebreak | charmap emoticons | fullscreen  preview save print | insertfile image media pageembed template link anchor codesample | a11ycheck ltr rtl | showcomments addcomment',
		autosave_ask_before_unload: true,
		autosave_interval: "30s",
		autosave_prefix: "{path}{query}-{id}-",
		autosave_restore_when_empty: false,
		autosave_retention: "2m",
		image_advtab: true,
		content_css: '//www.tiny.cloud/css/codepen.min.css',
		link_list: [
		{ title: 'My page 1', value: 'http://www.tinymce.com' },
		{ title: 'My page 2', value: 'http://www.moxiecode.com' }
		],
		image_list: [
		{ title: 'My page 1', value: 'http://www.tinymce.com' },
		{ title: 'My page 2', value: 'http://www.moxiecode.com' }
		],
		image_class_list: [
		{ title: 'None', value: '' },
		{ title: 'Some class', value: 'class-name' }
		],
		importcss_append: true,
		templates: [
		    { title: 'New Table', description: 'creates a new table', content: '<div class="mceTmpl"><table width="98%%"  border="0" cellspacing="0" cellpadding="0"><tr><th scope="col"> </th><th scope="col"> </th></tr><tr><td> </td><td> </td></tr></table></div>' },
		{ title: 'Starting my story', description: 'A cure for writers block', content: 'Once upon a time...' },
		{ title: 'New list with dates', description: 'New List with dates', content: '<div class="mceTmpl"><span class="cdate">cdate</span><br /><span class="mdate">mdate</span><h2>My List</h2><ul><li></li><li></li></ul></div>' }
		],
		template_cdate_format: '[Date Created (CDATE): %m/%d/%Y : %H:%M:%S]',
		template_mdate_format: '[Date Modified (MDATE): %m/%d/%Y : %H:%M:%S]',
		height: 480,
		image_caption: true,
		quickbars_selection_toolbar: 'bold italic | quicklink h2 h3 blockquote quickimage quicktable',
		noneditable_noneditable_class: "mceNonEditable",
		toolbar_mode: 'sliding',
		spellchecker_whitelist: ['Ephox', 'Moxiecode'],
		tinycomments_mode: 'embedded',
		content_style: ".mymention{ color: gray; }",
		contextmenu: "link image imagetools table configurepermanentpen",
		a11y_advanced_options: true,
			images_upload_url: 'https://www.epapodetarot.com.br/scripts/postAcceptor.php',
			images_upload_handler: function (blobInfo, success, failure, progress) {
		    var xhr, formData;
		    xhr = new XMLHttpRequest();
		    xhr.withCredentials = false;
		    xhr.open('POST', 'https://www.epapodetarot.com.br/scripts/postAcceptor.php');
		    xhr.upload.onprogress = function (e) {
		      progress(e.loaded / e.total * 100);
		    };
		    xhr.onload = function() {
		      var json;
		      if (xhr.status < 200 || xhr.status >= 300) {
		        failure('HTTP Error: ' + xhr.status);
		        return;
		      }
		      json = JSON.parse(xhr.responseText);
		      if (!json || typeof json.location != 'string') {
		        failure('Invalid JSON: ' + xhr.responseText);
		        return;
		      }
		      success(json.location);
		    };
		    xhr.onerror = function () {
		      failure('Image upload failed due to a XHR Transport error. Code: ' + xhr.status);
		    };
		    formData = new FormData();
		    formData.append('file', blobInfo.blob(), blobInfo.filename());
		    xhr.send(formData);
		},
    });
</script>