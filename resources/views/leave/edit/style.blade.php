@section('style')
<style>
.img-circle{
  width: 100%;
  border: 4px solid #87ceeb;
  background-size: cover;
  background-position: center;
  aspect-ratio: 1 / 1;
}

a.media-img .img-circle{
  width: 40px;
  border: 1px solid #87ceeb;
}

div.media-img .img-circle{
  width: 60px;
  border: 1px solid #87ceeb;
}

.img-circle.circle-danger{
  border: 4px solid #e74c3c;
}

.img-profile{
  position: relative;
  max-width: 300px;
  margin: auto;
}

.img-upload{
  display: none;
  position: absolute;
  background: rgba(0,0,0,.5);
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;
  border-radius: 50%;
  transition: all .3s linear;
  opacity: .7;
}

.img-upload img{
  position: absolute;
  left: 50%;
  top: 50%;
  transform: translate(-50%, -50%);
}

.tabs-line > li .nav-link.inactive{
  border-bottom: 3px solid #e43725 !important; 
}

.img-circle{
  width: 100%;
  border: 4px solid #87ceeb;
  aspect-ratio: 1 / 1;
  margin: 0 auto;
  overflow: hidden;
  position: relative;
}

.img-circle img{
  width: 110%;
  height: auto;
  transform: translate(-50%,-50%);
  position: absolute;
  left: 50%;
  top: 50%;
  object-fit: cover;
  max-width: 110%;
}

a.media-img .img-circle{
  width: 40px;
  border: 1px solid #87ceeb;
  background-size: cover;
  background-position: center;
}

div.media-img .img-circle{
  width: 60px;
  border: 1px solid #87ceeb;
  background-size: cover;
  background-position: center;
}

.img-circle.circle-danger{
  border: 4px solid #e74c3c;
}

.profile-social a {
  font-size: 16px;
  margin: 0 10px;
  color: #999;
}

.profile-social a:hover {
  color: #485b6f;
}

.profile-stat-count {
  font-size: 22px
}

.img-profile{
  position: relative;
}
</style>
@endsection
