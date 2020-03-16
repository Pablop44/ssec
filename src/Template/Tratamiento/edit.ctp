<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Tratamiento $tratamiento
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $tratamiento->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $tratamiento->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Tratamiento'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Medicamento'), ['controller' => 'Medicamento', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Medicamento'), ['controller' => 'Medicamento', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="tratamiento form large-9 medium-8 columns content">
    <?= $this->Form->create($tratamiento) ?>
    <fieldset>
        <legend><?= __('Edit Tratamiento') ?></legend>
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
