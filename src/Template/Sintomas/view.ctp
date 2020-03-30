<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Sintoma $sintoma
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Sintoma'), ['action' => 'edit', $sintoma->migranas]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Sintoma'), ['action' => 'delete', $sintoma->migranas], ['confirm' => __('Are you sure you want to delete # {0}?', $sintoma->migranas)]) ?> </li>
        <li><?= $this->Html->link(__('List Sintomas'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Sintoma'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="sintomas view large-9 medium-8 columns content">
    <h3><?= h($sintoma->migranas) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Sintomas') ?></th>
            <td><?= h($sintoma->sintomas) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Migranas') ?></th>
            <td><?= $this->Number->format($sintoma->migranas) ?></td>
        </tr>
    </table>
</div>
