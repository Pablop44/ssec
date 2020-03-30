<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Sintoma $sintoma
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $sintoma->migranas],
                ['confirm' => __('Are you sure you want to delete # {0}?', $sintoma->migranas)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Sintomas'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="sintomas form large-9 medium-8 columns content">
    <?= $this->Form->create($sintoma) ?>
    <fieldset>
        <legend><?= __('Edit Sintoma') ?></legend>
        <?php
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
