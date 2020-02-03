<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Consejo $consejo
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Consejo'), ['action' => 'edit', $consejo->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Consejo'), ['action' => 'delete', $consejo->id], ['confirm' => __('Are you sure you want to delete # {0}?', $consejo->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Consejo'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Consejo'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="consejo view large-9 medium-8 columns content">
    <h3><?= h($consejo->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Recomendacion') ?></th>
            <td><?= h($consejo->recomendacion) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($consejo->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Paciente') ?></th>
            <td><?= $this->Number->format($consejo->paciente) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Medico') ?></th>
            <td><?= $this->Number->format($consejo->medico) ?></td>
        </tr>
    </table>
</div>
