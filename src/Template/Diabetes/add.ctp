<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Diabetes $diabetes
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Diabetes'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="diabetes form large-9 medium-8 columns content">
    <?= $this->Form->create($diabetes) ?>
    <fieldset>
        <legend><?= __('Add Diabetes') ?></legend>
        <?php
            echo $this->Form->control('fecha');
            echo $this->Form->control('ficha');
            echo $this->Form->control('numeroControles');
            echo $this->Form->control('nivelBajo');
            echo $this->Form->control('frecuenciaBajo');
            echo $this->Form->control('horarioBajo');
            echo $this->Form->control('perdidaConocimiento');
            echo $this->Form->control('nivelAlto');
            echo $this->Form->control('frecuenciaAlto');
            echo $this->Form->control('horarioAlto');
            echo $this->Form->control('actividadFisica');
            echo $this->Form->control('problemaDieta');
            echo $this->Form->control('estadoGeneral');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
