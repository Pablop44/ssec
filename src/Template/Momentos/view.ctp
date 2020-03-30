<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Momento $momento
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Momento'), ['action' => 'edit', $momento->diabetes]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Momento'), ['action' => 'delete', $momento->diabetes], ['confirm' => __('Are you sure you want to delete # {0}?', $momento->diabetes)]) ?> </li>
        <li><?= $this->Html->link(__('List Momentos'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Momento'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="momentos view large-9 medium-8 columns content">
    <h3><?= h($momento->diabetes) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Momento') ?></th>
            <td><?= h($momento->momento) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Diabetes') ?></th>
            <td><?= $this->Number->format($momento->diabetes) ?></td>
        </tr>
    </table>
</div>
