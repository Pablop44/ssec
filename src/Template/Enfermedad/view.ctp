<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Enfermedad $enfermedad
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Enfermedad'), ['action' => 'edit', $enfermedad->nombre]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Enfermedad'), ['action' => 'delete', $enfermedad->nombre], ['confirm' => __('Are you sure you want to delete # {0}?', $enfermedad->nombre)]) ?> </li>
        <li><?= $this->Html->link(__('List Enfermedad'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Enfermedad'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Ficha'), ['controller' => 'Ficha', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Ficha'), ['controller' => 'Ficha', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="enfermedad view large-9 medium-8 columns content">
    <h3><?= h($enfermedad->nombre) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Nombre') ?></th>
            <td><?= h($enfermedad->nombre) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Ficha') ?></h4>
        <?php if (!empty($enfermedad->ficha)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('FechaCreacion') ?></th>
                <th scope="col"><?= __('Paciente') ?></th>
                <th scope="col"><?= __('Medico') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($enfermedad->ficha as $ficha): ?>
            <tr>
                <td><?= h($ficha->id) ?></td>
                <td><?= h($ficha->fechaCreacion) ?></td>
                <td><?= h($ficha->paciente) ?></td>
                <td><?= h($ficha->medico) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Ficha', 'action' => 'view', $ficha->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Ficha', 'action' => 'edit', $ficha->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Ficha', 'action' => 'delete', $ficha->id], ['confirm' => __('Are you sure you want to delete # {0}?', $ficha->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
