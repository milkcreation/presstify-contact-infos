<?php
/**
 * @var tiFy\Contracts\Metabox\MetaboxView $this
 * @var tiFy\Plugins\ContactInfos\Metabox\ContactInfosFieldBag $field
 * @var tiFy\Plugins\ContactInfos\Metabox\ContactInfosGroupBag $group
 */
?>
<?php foreach ($this->get('groups', []) as $group) : ?>
    <?php if ($fields = $group->getFields()) : ?>
        <h3 class="Form-title"><?php echo $group->getTitle(); ?></h3>

        <table class="Form-table">
            <tbody>
            <?php foreach ($fields as $field) : ?>
                <tr><?php echo $field->render(); ?></tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
<?php endforeach;