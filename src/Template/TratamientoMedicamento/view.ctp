<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\TratamientoMedicamento $tratamientoMedicamento
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Tratamiento Medicamento'), ['action' => 'edit', $tratamientoMedicamento->medicamento]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Tratamiento Medicamento'), ['action' => 'delete', $tratamientoMedicamento->medicamento], ['confirm' => __('Are you sure you want to delete # {0}?', $tratamientoMedicamento->medicamento)]) ?> </li>
        <li><?= $this->Html->link(__('List Tratamiento Medicamento'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Tratamiento Medicamento'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="tratamientoMedicamento view large-9 medium-8 columns content">
    <h3><?= h($tratamientoMedicamento->medicamento) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Medicamento') ?></th>
            <td><?= h($tratamientoMedicamento->medicamento) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($tratamientoMedicamento->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Tratamiento') ?></th>
            <td><?= $this->Number->format($tratamientoMedicamento->tratamiento) ?></td>
        </tr>
    </table>
</div>
