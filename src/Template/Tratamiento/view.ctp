<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Tratamiento $tratamiento
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Tratamiento'), ['action' => 'edit', $tratamiento->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Tratamiento'), ['action' => 'delete', $tratamiento->id], ['confirm' => __('Are you sure you want to delete # {0}?', $tratamiento->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Tratamiento'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Tratamiento'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Medicamento'), ['controller' => 'Medicamento', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Medicamento'), ['controller' => 'Medicamento', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="tratamiento view large-9 medium-8 columns content">
    <h3><?= h($tratamiento->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Posologia') ?></th>
            <td><?= h($tratamiento->posologia) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Enfermedad') ?></th>
            <td><?= h($tratamiento->enfermedad) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($tratamiento->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Ficha') ?></th>
            <td><?= $this->Number->format($tratamiento->ficha) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('FechaInicio') ?></th>
            <td><?= h($tratamiento->fechaInicio) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('FechaFin') ?></th>
            <td><?= h($tratamiento->fechaFin) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Horario') ?></th>
            <td><?= h($tratamiento->horario) ?></td>
        </tr>
    </table>
    <div class="related">
        <h4><?= __('Related Medicamento') ?></h4>
        <?php if (!empty($tratamiento->medicamento)): ?>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <th scope="col"><?= __('Nombre') ?></th>
                <th scope="col"><?= __('ViaAdministracion') ?></th>
                <th scope="col"><?= __('Marca') ?></th>
                <th scope="col"><?= __('Dosis') ?></th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
            </tr>
            <?php foreach ($tratamiento->medicamento as $medicamento): ?>
            <tr>
                <td><?= h($medicamento->nombre) ?></td>
                <td><?= h($medicamento->viaAdministracion) ?></td>
                <td><?= h($medicamento->marca) ?></td>
                <td><?= h($medicamento->dosis) ?></td>
                <td class="actions">
                    <?= $this->Html->link(__('View'), ['controller' => 'Medicamento', 'action' => 'view', $medicamento->nombre]) ?>
                    <?= $this->Html->link(__('Edit'), ['controller' => 'Medicamento', 'action' => 'edit', $medicamento->nombre]) ?>
                    <?= $this->Form->postLink(__('Delete'), ['controller' => 'Medicamento', 'action' => 'delete', $medicamento->nombre], ['confirm' => __('Are you sure you want to delete # {0}?', $medicamento->nombre)]) ?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>
    </div>
</div>
