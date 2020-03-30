<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Factore $factore
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Factore'), ['action' => 'edit', $factore->migranas]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Factore'), ['action' => 'delete', $factore->migranas], ['confirm' => __('Are you sure you want to delete # {0}?', $factore->migranas)]) ?> </li>
        <li><?= $this->Html->link(__('List Factores'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Factore'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="factores view large-9 medium-8 columns content">
    <h3><?= h($factore->migranas) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Factores') ?></th>
            <td><?= h($factore->factores) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Migranas') ?></th>
            <td><?= $this->Number->format($factore->migranas) ?></td>
        </tr>
    </table>
</div>
