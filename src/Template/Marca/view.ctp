<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Marca $marca
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Marca'), ['action' => 'edit', $marca->nombre]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Marca'), ['action' => 'delete', $marca->nombre], ['confirm' => __('Are you sure you want to delete # {0}?', $marca->nombre)]) ?> </li>
        <li><?= $this->Html->link(__('List Marca'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Marca'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="marca view large-9 medium-8 columns content">
    <h3><?= h($marca->nombre) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Nombre') ?></th>
            <td><?= h($marca->nombre) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Pais') ?></th>
            <td><?= h($marca->pais) ?></td>
        </tr>
    </table>
</div>
