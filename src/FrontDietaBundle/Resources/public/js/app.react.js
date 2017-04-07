var RecetaSection = React.createClass({


render: function (){

    return (

        <div class="col-xs-12 col-md-6 col-lg-4 item">
            <div class="timeline-block">
                <div class="panel panel-default">

                    <div class="panel-heading">
                        <div class="media">

                            <div class="media-body">
                                <a href="#" class="pull-right text-muted"><i class="icon-reply-all-fill fa fa-2x "></i></a>
                                <a href=""></a>
                            </div>
                        </div>
                    </div>

                    <img src="" class="img-responsive">
                        <ul class="comments">
                            <li clas="media">

                                <div class="media-body">
                                    <div class="pull-right dropdown" data-show-hover="li">
                                        <a href="#" data-toggle="dropdown" class="toggle-button">
                                            <i class="fa fa-pencil"></i>
                                        </a>
                                        <ul class="dropdown-menu" role="menu">
                                            <li><a href="#">Edit</a></li>
                                            <li><a href="#">Delete</a></li>
                                        </ul>
                                    </div>
                                    <span></span>
                                    <div class="comment-date">2 days</div>
                                </div>
                            </li>

                        </ul>
                </div>

            </div>
        </div>


    );

}




});