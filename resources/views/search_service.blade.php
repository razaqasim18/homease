<div class="row">
    @foreach($data as $row)
    <?php $image = asset('uploads/service') . '/' . $row->image;?>
    <div class="col-md-6 col-sm-6 col-xs-12 blog-item">
        <div class="latest-item">
            <div class="latest-photo" style="background-image: url(<?php echo $image; ?>)">
            </div>
            <div class="latest-text">
                <h2><a href="<?php $title = str_replace(' ', '-', $row->title);
$title = preg_replace('/[^A-Za-z0-9\-]/', '', $title);
echo url("service/" . $title . '/' . base64_encode($row->serviceid));?>"><?php echo $row->title; ?></a></h2>
                <ul>
                    <li>Date: <?php $orgDate = $row->created_at;
$newDate = date("d:m:Y", strtotime($orgDate));
echo $newDate;?></li>
                </ul>
                <div class="latest-pra">
                    <p></p>
                    <div style="height: 45px;overflow: hidden;">
                        <?php echo trim(substr($row->description, 0, 170)) . "...."; ?>
                    </div>
                    <a href="<?php $title = str_replace(' ', '-', $row->title);
$title = preg_replace('/[^A-Za-z0-9\-]/', '', $title);
echo url("service/" . $title . '/' . base64_encode($row->serviceid));?>">View more</a>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
<div class="col-md-6 col-sm-6 col-xs-12">
    <!-- {!! $data->links() !!} -->
    {!! $data->links('paginate') !!}
</div>