
<?php $__env->startSection('content'); ?>
<div class="container" style="padding-top: 2%">
    <div class="card">

        <div class="card-body">

            <p class="card-text"> Card footer</p>
        </div>
    </div>
</div>
<div class="container" style="padding-top: 2%"> 
        <div class="form-group">
            <label for="exampleFormControlInput1">Text</label>
            <input type="text" name="text" class="form-control" placeholder="post text">
        </div>
        <div class="form-group">
            <label for="exampleFormControlInput1">photo</label>
            <input type="file" name="img" class="form-control" placeholder="post img">
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-info">Save</button></div>
    </form>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('post.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laravel project\socialmedia\resources\views/post/create.blade.php ENDPATH**/ ?>