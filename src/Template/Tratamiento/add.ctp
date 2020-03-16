<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Tratamiento $tratamiento
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Tratamiento'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Medicamento'), ['controller' => 'Medicamento', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Medicamento'), ['controller' => 'Medicamento', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="tratamiento form large-9 medium-8 columns content">
    <?= $this->Form->create($tratamiento) ?>
    <fieldset>
        <legend><?= __('Add Tratamiento') ?></legend>
        <?php
            echo $this->Form->control('posologia');
            echo $this->Form->control('fechaInicio');
            echo $this->Form->control('fechaFin');
            echo $this->Form->control('horario');
            echo $this->Form->control('enfermedad');
            echo $this->Form->control('ficha');
            echo $this->Form->control('medicamento._ids', ['options' => $medicamento]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
