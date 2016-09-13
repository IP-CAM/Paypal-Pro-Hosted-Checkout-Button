<!--
/*
 * @support
 * http://www.opensourcetechnologies.com/contactus.html
 * sales@opensourcetechnologies.com
* */
-->
<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-pphosted-button" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
  <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
      </div>
      <div class="panel-body">
		<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-pphosted-button" class="form-horizontal">

		<?php foreach ($fields as $field) { 
		if($field['required']){?>
			<div class="form-group required">
		<?php
		}
		else
		{
		?>
			<div class="form-group">
		<?php 
		}
		?>	
        <label class="col-sm-3 control-label" for="input-<?php echo $field['name'];?>"><span data-toggle="tooltip" title="<?php echo $field['help']; ?>"><?php echo $field['entry']; ?></span></label>
            <div class="col-sm-9">
			<?php if ($field['type'] == 'select') { ?>
				<select name="<?php echo $field['name'];?>" id="input-<?php echo $field['name'];?>" class="form-control" >	
					<?php foreach ($field['options'] as $key => $value) : ?>
					<option value="<?php echo $key; ?>"<?php if((is_array($field['value']) && in_array($key, $field['value'])) || ($field['value'] == $key)) echo ' selected="selected"'?>><?php echo $value; ?></option>
					<?php endforeach; ?>
				</select>	
			<?php } elseif ($field['type'] == 'radio') {?>
					<?php foreach($field['options'] as $key => $value) : ?>
							<input type="radio" name="<?php echo $field['name']; ?>" id="<?php echo $field['name']; ?>" value="<?php echo $key; ?>"<?php if($field['value'] == $key) echo ' checked="checked"'; ?> class="form-control" /><label for="<?php echo $field['name']; ?>"><?php echo $value; ?></label>
				<?php endforeach; ?>
			<?php } elseif ($field['type'] == 'text') {?>
							<input type="text" name="<?php echo $field['name']; ?>" value="<?php echo $field['value']; ?>" <?php echo (isset($field['size']) && $field['size']) ? 'size="' . $field['size'] . '"' : ''?>  id="input-<?php echo $field['name'];?>"  class="form-control"/>
			<?php } elseif ($field['type'] == 'password') {?>
										<input type="password" name="<?php echo $field['name']; ?>" value="<?php echo $field['value']; ?>" <?php echo (isset($field['size']) && $field['size']) ? 'size="' . $field['size'] . '"' : ''?>id="input-<?php echo $field['name'];?>"  class="form-control" />
			<?php } elseif ($field['type'] == 'checkbox') {?>
										<input type="checkbox" name="<?php echo $field['name']; ?>" id="<?php echo $field['name']; ?>" value="1"<?php if($field['value']) echo 'checked="checked"'; ?> id="input-<?php echo $field['name'];?>"  class="form-control" />
			<?php } elseif ($field['type'] == 'file') {?>
										<input type="file" name="<?php echo $field['name']; ?>" value="" <?php echo (isset($field['size']) && $field['size']) ? 'size="' . $field['size'] . '"' : ''?> id="input-<?php echo $field['name'];?>"  class="form-control" />
			<?php } elseif ($field['type'] == 'textarea') {?>
										<textarea name="<?php echo $field['name']; ?>" cols="<?php echo $field['cols']; ?>" rows="<?php echo $field['rows']; ?>" id="input-<?php echo $field['name'];?>"  class="form-control"><?php echo $field['value']; ?></textarea>
			<?php } elseif ($field['type'] == 'hidden') {?>
										<input type="hidden" name="<?php echo $field['name']; ?>" value="<?php echo $field['value']; ?>" id="input-<?php echo $field['name'];?>"  class="form-control"/>
			<?php } ?>
			<?php if (!empty($field['error'])) { ?>
										<div class="text-danger"><?php echo $field['error']; ?></div>
			<?php } ?>
			
             
              
            </div>
          </div>
		<?php } // end foreach fields ?>
		

		</form>
	</div>
</div>
</div>
</div>
<?php echo $footer; ?>
