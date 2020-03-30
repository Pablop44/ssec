<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Migrana $migrana
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Migranas'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="migranas form large-9 medium-8 columns content">
    <?= $this->Form->create($migrana) ?>
    <fieldset>
        <legend><?= __('Add Migrana') ?></legend>
        <?php
            echo $this->Form->control('fecha');
            echo $this->Form->control('ficha');
            echo $this->Form->control('frecuencia');
            echo $this->Form->control('duracion');
            echo $this->Form->control('horario');
            echo $this->Form->control('finalizacion');
            echo $this->Form->control('tipoEpisodio');
            echo $this->Form->control('intensidad');
            echo $this->Form->control('limitaciones');
            echo $this->Form->control('despiertoNoche');
            echo $this->Form->control('estadoGeneral');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
