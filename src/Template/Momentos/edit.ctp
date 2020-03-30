<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Momento $momento
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $momento->diabetes],
                ['confirm' => __('Are you sure you want to delete # {0}?', $momento->diabetes)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Momentos'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="momentos form large-9 medium-8 columns content">
    <?= $this->Form->create($momento) ?>
    <fieldset>
        <legend><?= __('Edit Momento') ?></legend>
        <?php
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
