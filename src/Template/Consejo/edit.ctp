<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Consejo $consejo
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $consejo->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $consejo->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Consejo'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="consejo form large-9 medium-8 columns content">
    <?= $this->Form->create($consejo) ?>
    <fieldset>
        <legend><?= __('Edit Consejo') ?></legend>
        <?php
            echo $this->Form->control('recomendacion');
            echo $this->Form->control('paciente');
            echo $this->Form->control('medico');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
