<?php defined("SYSPATH") or die("No direct script access.") ?>
<div id="l10n-client" class="hidden">
  <div class="labels">
    <span id="l10n-client-toggler">
      <a id="g-minimize-l10n">_</a>
      <a id="g-close-l10n" title="<?php echo t("Stop the translation mode")->for_html_attr() ?>"
         href="<?php echo html::clean_attribute(url::site("l10n_client/toggle_l10n_mode?csrf=".access::csrf_token())) ?>">X</a>
    </span>
    <div class="label strings"><h2><?php echo t("Page text") ?>
    <?php if (!Input::instance()->get('show_all_l10n_messages')): ?>
      <a style="background-color:#fff" href="<?php echo url::site("admin/languages?show_all_l10n_messages=1") ?>"><?php echo t("(Show all)") ?></a>
    <?php endif; ?>
    </h2></div>
    <div class="label source"><h2><?php echo t("Source") ?></div>
    <div class="label translation"><h2><?php echo t("Translation to %language",
                                             array("language" => locales::display_name())) ?></h2></div>
  </div>
  <div id="l10n-client-string-select">
    <ul class="string-list">
      <?php foreach ($string_list as $string): ?>
      <li class="<?php echo $string["translation"] === ""  ? "untranslated" : "translated" ?>">
        <?php if (is_array($string["source"])): ?>
       [one] - <?php echo $string["source"]["one"] ?><br/>
       [other] - <?php echo $string["source"]["other"] ?>
        <?php else: ?>
        <?php echo $string["source"] ?>
        <?php endif; ?>
      </li>
      <?php endforeach; ?>
    </ul>

    <?php echo $l10n_search_form ?>
  </div>
  <div id="l10n-client-string-editor">
    <div class="source">
      <p class="source-text"></p>
      <p id="source-text-tmp-space" style="display:none"></p>
    </div>
    <div class="translation">
      <form method="post" action="<?php echo url::site("l10n_client/save") ?>" id="g-l10n-client-save-form">
        <?php echo access::csrf_form_field() ?>
        <?php echo form::hidden("l10n-message-key") ?>
        <?php echo form::textarea("l10n-edit-translation", "", ' id="l10n-edit-translation" rows="5" class="translationField"') ?>
        <div id="plural-zero" class="translationField hidden">
          <label for="l10n-edit-plural-translation-zero">[zero]</label>
          <?php echo form::textarea("l10n-edit-plural-translation-zero", "", ' rows="2"') ?>
        </div>
        <div id="plural-one" class="translationField hidden">
          <label for="l10n-edit-plural-translation-one">[one]</label>
          <?php echo form::textarea("l10n-edit-plural-translation-one", "", ' rows="2"') ?>
        </div>
        <div id="plural-two" class="translationField hidden">
          <label for="l10n-edit-plural-translation-two">[two]</label>
          <?php echo form::textarea("l10n-edit-plural-translation-two", "", ' rows="2"') ?>
        </div>
        <div id="plural-few" class="translationField hidden">
          <label for="l10n-edit-plural-translation-few">[few]</label>
          <?php echo form::textarea("l10n-edit-plural-translation-few", "", ' rows="2"') ?>
        </div>
        <div id="plural-many" class="translationField hidden">
          <label for="l10n-edit-plural-translation-many">[many]</label>
          <?php echo form::textarea("l10n-edit-plural-translation-many", "", ' rows="2"') ?>
        </div>
        <div id="plural-other" class="translationField hidden">
          <label for="l10n-edit-plural-translation-other">[other]</label>
          (<a href="http://www.unicode.org/cldr/data/charts/supplemental/language_plural_rules.html"><?php echo t("learn more about plural forms") ?></a>)
          <?php echo form::textarea("l10n-edit-plural-translation-other", "", ' rows="2"') ?>
        </div>
        <input type="submit" name="l10n-edit-save" value="<?php echo t("Save translation")->for_html_attr() ?>"/>
        <a href="javascript: Gallery.l10nClient.copySourceText()"
           class="g-button ui-state-default ui-corner-all"><?php echo t("Copy source text") ?></a>
      </form>
    </div>
  </div>
  <script type="text/javascript">
    var MSG_TRANSLATE_TEXT = <?php echo t("Translate text")->for_js() ?>;
    var l10n_client_data = <?php echo json_encode($string_list) ?>;
    var plural_forms = <?php echo json_encode($plural_forms) ?>;
    var toggle_l10n_mode_url = <?php echo html::js_string(url::site("l10n_client/toggle_l10n_mode")) ?>;
    var csrf = <?php echo html::js_string(access::csrf_token()) ?>;
  </script>
</div>
