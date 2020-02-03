<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Medicamento $medicamento
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Medicamento'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Tratamiento'), ['controller' => 'Tratamiento', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Tratamiento'), ['controller' => 'Tratamiento', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="medicamento form large-9 medium-8 columns content">
    <?= $this->Form->create($medicamento) ?>
    <fieldset>
        <legend><?= __('Add Medicamento') ?></legend>
        <?php
            echo $this->Form->control('viaAdministracion');
            echo $this->Form->control('marca');
            echo $this->Form->control('tratamiento._ids', ['options' => $tratamiento]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
