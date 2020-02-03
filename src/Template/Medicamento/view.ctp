<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Medicamento $medicamento
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Medicamento'), ['action' => 'edit', $medicamento->nombre]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Medicamento'), ['action' => 'delete', $medicamento->nombre], ['confirm' => __('Are you sure you want to delete # {0}?', $medicamento->nombre)]) ?> </li>
        <li><?= $this->Html->link(__('List Medicamento'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Medicamento'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Tratamiento'), ['controller' => 'Tratamiento', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Tratamiento'), ['controller' => 'Tratamiento', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="medicamento view large-9 medium-8 columns content">
    <h3><?= h($medicamento->nombre) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Nombre') ?></th>
            <td><?= h($medicamento->nombre) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('ViaAdministracion') ?></th>
            <td><?= h($medicamento->viaAdministracion) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Marca') ?></th>
            <td><?= h($medicamento->marca) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Tratamiento') ?></h4>
        <?php if (!empty($medicamento->tratamiento)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Id') ?></th>
                <th scope="col"><?= __('Posologia') ?></th>
                <th scope="col"><?= __('FechaInicio') ?></th>
                <th scope="col"><?= __('FechaFin') ?></th>
                <th scope="col"><?= __('Horario') ?></th>
                <th scope="col"><?= __('Enfermedad') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($medicamento->tratamiento as $tratamiento): ?>
            <tr>
                <td><?= h($tratamiento->id) ?></td>
                <td><?= h($tratamiento->posologia) ?></td>
                <td><?= h($tratamiento->fechaInicio) ?></td>
                <td><?= h($tratamiento->fechaFin) ?></td>
                <td><?= h($tratamiento->horario) ?></td>
                <td><?= h($tratamiento->enfermedad) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Tratamiento', 'action' => 'view', $tratamiento->id]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Tratamiento', 'action' => 'edit', $tratamiento->id]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Tratamiento', 'action' => 'delete', $tratamiento->id], ['confirm' => __('Are you sure you want to delete # {0}?', $tratamiento->id)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
