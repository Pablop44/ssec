<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Diabetes $diabetes
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Diabetes'), ['action' => 'edit', $diabetes->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Diabetes'), ['action' => 'delete', $diabetes->id], ['confirm' => __('Are you sure you want to delete # {0}?', $diabetes->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Diabetes'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Diabetes'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="diabetes view large-9 medium-8 columns content">
    <h3><?= h($diabetes->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('NivelBajo') ?></th>
            <td><?= h($diabetes->nivelBajo) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('FrecuenciaBajo') ?></th>
            <td><?= h($diabetes->frecuenciaBajo) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('HorarioBajo') ?></th>
            <td><?= h($diabetes->horarioBajo) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('PerdidaConocimiento') ?></th>
            <td><?= h($diabetes->perdidaConocimiento) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('NivelAlto') ?></th>
            <td><?= h($diabetes->nivelAlto) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('FrecuenciaAlto') ?></th>
            <td><?= h($diabetes->frecuenciaAlto) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('HorarioAlto') ?></th>
            <td><?= h($diabetes->horarioAlto) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('ActividadFisica') ?></th>
            <td><?= h($diabetes->actividadFisica) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('ProblemaDieta') ?></th>
            <td><?= h($diabetes->problemaDieta) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('EstadoGeneral') ?></th>
            <td><?= h($diabetes->estadoGeneral) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($diabetes->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Ficha') ?></th>
            <td><?= $this->Number->format($diabetes->ficha) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('NumeroControles') ?></th>
            <td><?= $this->Number->format($diabetes->numeroControles) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Fecha') ?></th>
            <td><?= h($diabetes->fecha) ?></td>
        </tr>
    </table>
</div>
