<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Cuentum $cuentum
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Cuenta'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="cuenta form large-9 medium-8 columns content">
    <?= $this->Form->create($cuentum) ?>
    <fieldset>
        <legend><?= __('Add Cuentum') ?></legend>
        <?php
            echo $this->Form->control('rol');
            echo $this->Form->control('estado');
            echo $this->Form->control('user');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
