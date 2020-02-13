<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Ficha $ficha
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Ficha'), ['action' => 'edit', $ficha->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Ficha'), ['action' => 'delete', $ficha->id], ['confirm' => __('Are you sure you want to delete # {0}?', $ficha->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Ficha'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Ficha'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Enfermedad'), ['controller' => 'Enfermedad', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Enfermedad'), ['controller' => 'Enfermedad', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="ficha view large-9 medium-8 columns content">
    <h3><?= h($ficha->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($ficha->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Paciente') ?></th>
            <td><?= $this->Number->format($ficha->paciente) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Medico') ?></th>
            <td><?= $this->Number->format($ficha->medico) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('FechaCreacion') ?></th>
            <td><?= h($ficha->fechaCreacion) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Enfermedad') ?></h4>
        <?php if (!empty($ficha->enfermedad)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Nombre') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($ficha->enfermedad as $enfermedad): ?>
            <tr>
                <td><?= h($enfermedad->nombre) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Enfermedad', 'action' => 'view', $enfermedad->nombre]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Enfermedad', 'action' => 'edit', $enfermedad->nombre]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Enfermedad', 'action' => 'delete', $enfermedad->nombre], ['confirm' => __('Are you sure you want to delete # {0}?', $enfermedad->nombre)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
