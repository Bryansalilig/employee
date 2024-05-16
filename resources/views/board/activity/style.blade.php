<style type="text/css">
#image_url {
  display: none;
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

.img-upload {
  cursor: pointer;
  position: relative;
}

.img-upload:after {
  position: absolute;
  content: '';
  background: url("{{ URL::to('public/img/icon-upload.png') }}") center center/cover no-repeat, #000;
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;
  display: none;
  opacity: .6;
}

.img-upload:hover:after {
  display: block;
}
</style>
