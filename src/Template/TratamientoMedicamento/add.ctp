<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\TratamientoMedicamento $tratamientoMedicamento
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Tratamiento Medicamento'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="tratamientoMedicamento form large-9 medium-8 columns content">
    <?= $this->Form->create($tratamientoMedicamento) ?>
    <fieldset>
        <legend><?= __('Add Tratamiento Medicamento') ?></legend>
        <?php
            echo $this->Form->control('id');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
