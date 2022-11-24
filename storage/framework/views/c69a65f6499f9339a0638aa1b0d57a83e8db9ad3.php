

<?php $__env->startSection('content'); ?>
<div class="jumbotron container">

    <p>It uses utility classes for typography and spacing to space content out within the larger container.</p>

    <a class="btn btn-primary btn-lg" href="#" role="button">Learn more</a>

  </div>

  <div class="container">

    <table class="table">

        <thead class="thead-dark">

          <tr>


            <th scope="col">text</th>

            <th scope="col">img</th>


          </tr>

        </thead>

        <tbody>
          <?php
              $i = 0;
          ?>
         <?php $__currentLoopData = $post; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

            <tr>

                <th scope="row"><?php echo e(++$i); ?></th>

                <td><?php echo e($item->text); ?></td>

                <td><?php echo e($item->img); ?></td>

                <td>

                    <a href="<?php echo e(route('post.edit',$item->id)); ?>"></a>

                    <a href="<?php echo e(route('post.show',$item->id)); ?>"></a>

                    <form action="<?php echo e(route('post.destroy',$item->id)); ?>">

                    <?php echo csrf_field(); ?>

                    <?php echo method_field('DELETE'); ?>

                    <BUtton type="submit" class="btn btn-danger">Delete</BUtton>

                    </form>

                </td>

              </tr>

            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
         
        </tbody>
      </table>
      <?php echo $post->links(); ?>

  </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('post.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laravel project\socialmedia\resources\views/post/index.blade.php ENDPATH**/ ?>