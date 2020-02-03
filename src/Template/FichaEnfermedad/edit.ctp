<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\FichaEnfermedad $fichaEnfermedad
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $fichaEnfermedad->ficha],
                ['confirm' => __('Are you sure you want to delete # {0}?', $fichaEnfermedad->ficha)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Ficha Enfermedad'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="fichaEnfermedad form large-9 medium-8 columns content">
    <?= $this->Form->create($fichaEnfermedad) ?>
    <fieldset>
        <legend><?= __('Edit Ficha Enfermedad') ?></legend>
        <?php
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
