<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Enfermedad $enfermedad
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Enfermedad'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Ficha'), ['controller' => 'Ficha', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Ficha'), ['controller' => 'Ficha', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="enfermedad form large-9 medium-8 columns content">
    <?= $this->Form->create($enfermedad) ?>
    <fieldset>
        <legend><?= __('Add Enfermedad') ?></legend>
        <?php
            echo $this->Form->control('ficha._ids', ['options' => $ficha]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
