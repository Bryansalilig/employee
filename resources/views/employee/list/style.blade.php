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
</style>
@endsection
