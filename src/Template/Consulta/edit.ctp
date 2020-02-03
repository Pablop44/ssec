<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Consultum $consultum
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $consultum->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $consultum->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Consulta'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="consulta form large-9 medium-8 columns content">
    <?= $this->Form->create($consultum) ?>
    <fieldset>
        <legend><?= __('Edit Consultum') ?></legend>
        <?php
            echo $this->Form->control('lugar');
            echo $this->Form->control('motivo');
            echo $this->Form->control('fecha');
            echo $this->Form->control('diagnostico');
            echo $this->Form->control('observaciones');
            echo $this->Form->control('medico');
            echo $this->Form->control('paciente');
            echo $this->Form->control('ficha');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
