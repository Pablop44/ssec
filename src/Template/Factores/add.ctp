<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Factore $factore
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Factores'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="factores form large-9 medium-8 columns content">
    <?= $this->Form->create($factore) ?>
    <fieldset>
        <legend><?= __('Add Factore') ?></legend>
        <?php
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
