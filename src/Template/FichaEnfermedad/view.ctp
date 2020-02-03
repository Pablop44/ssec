<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\FichaEnfermedad $fichaEnfermedad
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Ficha Enfermedad'), ['action' => 'edit', $fichaEnfermedad->ficha]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Ficha Enfermedad'), ['action' => 'delete', $fichaEnfermedad->ficha], ['confirm' => __('Are you sure you want to delete # {0}?', $fichaEnfermedad->ficha)]) ?> </li>
        <li><?= $this->Html->link(__('List Ficha Enfermedad'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Ficha Enfermedad'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="fichaEnfermedad view large-9 medium-8 columns content">
    <h3><?= h($fichaEnfermedad->ficha) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Enfermedad') ?></th>
            <td><?= h($fichaEnfermedad->enfermedad) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Ficha') ?></th>
            <td><?= $this->Number->format($fichaEnfermedad->ficha) ?></td>
        </tr>
    </table>
</div>
