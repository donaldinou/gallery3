<?php defined("SYSPATH") or die("No direct script access.") ?>
<script type="text/javascript">
  var form_url = "<?php echo url::site("permissions/form/__ITEM__") ?>";
  show = function(id) {
    $.ajax({
      url: form_url.replace("__ITEM__", id),
      success: function(data) {
          $("#g-edit-permissions-form").html(data);
          $(".g-active").removeClass("g-active");
          $("#item-" + id).addClass("g-active");
      }
    });
  }

  var action_url =
    "<?php echo url::site("permissions/change/__CMD__/__GROUP__/__PERM__/__ITEM__?csrf=$csrf") ?>";
  set = function(cmd, group_id, perm_id, item_id) {
    $.ajax({
      url: action_url.replace("__CMD__", cmd).replace("__GROUP__", group_id).
           replace("__PERM__", perm_id).replace("__ITEM__", item_id),
      success: function(data) {
        $("#g-edit-permissions-form").load(form_url.replace("__ITEM__", item_id));
      }
    });
  }
</script>
<div id="g-permissions">
  <?php if (!$htaccess_works): ?>
  <ul id="g-action-status" class="g-message-block">
    <li class="g-error">
      <?php echo t("Oh no!  Your server needs a configuration change in order for you to hide photos!  Ask your server administrator to enable <a %mod_rewrite_attrs>mod_rewrite</a> and set <a %apache_attrs><i>AllowOverride FileInfo Options</i></a> to fix this.",
            array("mod_rewrite_attrs" => html::mark_clean('href="http://httpd.apache.org/docs/2.0/mod/mod_rewrite.html" target="_blank"'),
                  "apache_attrs" => html::mark_clean('href="http://httpd.apache.org/docs/2.0/mod/core.html#allowoverride" target="_blank"'))) ?>
    </li>
  </ul>
  <?php endif ?>

  <p><?php echo t("Edit permissions for album:") ?></p>

  <ul class="g-breadcrumbs">
    <?php $i = 0 ?>
    <?php foreach ($parents as $parent): ?>
    <li id="item-<?php echo $parent->id ?>"<?php if ($i == 0) print " class=\"g-first\"" ?>>
      <?php if (access::can("edit", $parent)): ?>
      <a href="javascript:show(<?php echo $parent->id ?>)"> <?php echo html::purify($parent->title) ?> </a>
      <?php else: ?>
      <?php echo html::purify($parent->title) ?>
      <?php endif ?>
    </li>
    <?php $i++ ?>
    <?php endforeach ?>
    <li class="g-active" id="item-<?php echo $item->id ?>">
      <a href="javascript:show(<?php echo $item->id ?>)">
        <?php echo html::purify($item->title) ?>
      </a>
    </li>
  </ul>

  <div id="g-edit-permissions-form">
    <?php echo $form ?>
  </div>
</div>
