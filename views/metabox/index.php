<?php
/**
 * @var tiFy\Contracts\Metabox\MetaboxView $this
 * @var tiFy\Plugins\ContactInfos\Metabox\ContactInfosFieldBag $field
 * @var tiFy\Plugins\ContactInfos\Metabox\ContactInfosGroupBag $group
 */
?>
<div <?php $this->htmlAttrs(); ?>>
    <div class="ContactInfosMetabox-groups">
        <?php $this->insert('groups', $this->all()); ?>
    </div>
</div>
