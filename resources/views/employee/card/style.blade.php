@section('style')
<style>
.candidate-list-images a{
  display: block;
}
.avatar-md{
  height: 5rem;
  width: 5rem;
  border: 2px solid #87ceeb;
  background-size: cover;
  background-position: center;
}
.candidate-list-box .favorite-icon{
  position: absolute;
  right: 22px;
  top: 22px;
}
.favorite-icon a.dropdown-toggle{
display: inline-block;
  width: 30px;
  height: 30px;
  font-size: 18px;
  line-height: 30px;
  text-align: center;
  border: 1px solid #eff0f2;
  border-radius: 6px;
  color: #000;
  -webkit-transition: all .5s ease;
  transition: all .5s ease;
}
.pagination-data{
  text-align: center;
  margin: -25px auto -15px;
}
.pagination-data div:last-child{
  display: none;
}
.pagination-data nav span.px-4, .pagination-data nav a.px-4{
  padding: 5px 10px !important;
}
.pagination-data nav a:hover{
  background: #e3e6e7 !important;
  color: #485b6f;
}
.pagination-data nav span[aria-current="page"], .pagination-data nav span[aria-disabled="true"]{
  margin-right: -4px;
}
.pagination-data nav span[aria-current="page"] span{
  background: #337ab7 !important;
  color: #fff !important;
}
.img-no-result{
  width: 200px;
  margin:0 auto 25px;
}
@if(!$active)
.avatar-md{
  border: 2px solid #e74c3c;
}

.primary-link{
  color: #e74c3c;
}
@endif

.img-circle{
  width: 80%;
  border: 4px solid #87ceeb;
  background-size: cover;
  background-position: center;
  aspect-ratio: 1 / 1;
  margin: 0 auto;
}

a.media-img .img-circle{
  width: 40px;
  border: 1px solid #87ceeb;
}

div.media-img .img-circle{
  width: 60px !important;
  border: 1px solid #87ceeb;
}

.img-circle.circle-danger{
  border: 4px solid #e74c3c;
}

#card-data .text-align-center {
  display: flex;
  justify-content: center;
  align-items: center;
}

#card-data .btn-block{
  font-size: 11px;
  padding: 5px;
}

#card-data .ibox .ibox-head{
  height: 40px;
}

#card-data .ibox{
  cursor: pointer;
}

#card-data .ibox .img-circle{
  transition: ease transform 300ms;
  background-size: unset;
  background-position: unset;
  overflow: hidden;
  position: relative;
}

#card-data .ibox .img-circle img{
  width: 110%;
  height: auto;
  transform: translate(-50%,-50%);
  position: absolute;
  left: 50%;
  top: 50%;
  object-fit: cover;
  max-width: 110%;
}

#card-data .ibox:hover .img-circle{
  transform: scale(1.1);
  border: 4px solid #1abc9c;
}

#card-data .ibox:hover .ibox-head{
  background: #1abc9c;
}

#card-data .ibox:hover h5{
  color: #1abc9c;
}

#card-data .ibox:hover .text-muted{
  color: #000 !important;
}

#card-data .ibox .ibox-head .ibox-title{
  font-size: 14px;
}

#card-data .text-email {
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}

#modal-employee-body {
  background: #f1f1f1;
}

#modal-employee-body .img-circle {
  width: 100%;
}

.word-break {
  word-wrap: break-word;
}
</style>
@endsection
