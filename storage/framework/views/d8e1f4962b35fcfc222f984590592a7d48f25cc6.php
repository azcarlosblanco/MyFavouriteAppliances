<div class="form-group"><?php echo e($errors->has($name) ? ' has-error' : ''); ?>

    <?php echo e(Form::label($name, $label_name, ['class' => 'control-label'])); ?>


    <?php $__currentLoopData = $values; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <label class="checkbox-inline">
            <input type="checkbox" name="<?php echo e($name); ?>[]" value="<?php echo e($value["value"]); ?>" <?php echo e($value["is_checked"] ? "checked" : null); ?>><?php echo e($value["text"]); ?>

        </label>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


    <?php if($errors->has($name)): ?>
        <span class="help-block">
            <strong><?php echo e($errors->first($name)); ?></strong>
        </span>
    <?php endif; ?>

</div>