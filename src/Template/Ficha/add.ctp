<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Ficha $ficha
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Ficha'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Enfermedad'), ['controller' => 'Enfermedad', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Enfermedad'), ['controller' => 'Enfermedad', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="ficha form large-9 medium-8 columns content">
    <?= $this->Form->create($ficha) ?>
    <fieldset>
        <legend><?= __('Add Ficha') ?></legend>
        <?php
            echo $this->Form->control('fechaCreacion');
            echo $this->Form->control('paciente');
            echo $this->Form->control('medico');
            echo $this->Form->control('enfermedad._ids', ['options' => $enfermedad]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
