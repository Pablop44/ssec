<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Asma $asma
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Asma'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="asma form large-9 medium-8 columns content">
    <?= $this->Form->create($asma) ?>
    <fieldset>
        <legend><?= __('Add Asma') ?></legend>
        <?php
            echo $this->Form->control('fecha');
            echo $this->Form->control('ficha');
            echo $this->Form->control('calidadSueno');
            echo $this->Form->control('dificultadRespirar');
            echo $this->Form->control('tos');
            echo $this->Form->control('gravedadTos');
            echo $this->Form->control('limitaciones');
            echo $this->Form->control('silbidos');
            echo $this->Form->control('usoMedicacion');
            echo $this->Form->control('espirometria');
            echo $this->Form->control('factoresCrisis');
            echo $this->Form->control('estadoGeneral');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
