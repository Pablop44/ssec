<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Notum $notum
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Nota'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="nota form large-9 medium-8 columns content">
    <?= $this->Form->create($notum) ?>
    <fieldset>
        <legend><?= __('Add Notum') ?></legend>
        <?php
            echo $this->Form->control('fecha');
            echo $this->Form->control('datos');
            echo $this->Form->control('ficha');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
