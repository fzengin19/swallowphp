<style>
    .cat {
  position: relative;
  width: 150px;
  height: 100px;
  border-radius: 50% 50% 0 0;
  background-color: #000;
  overflow: hidden;
}

.cat::before {
  content: "";
  position: absolute;
  top: 10px;
  left: 20px;
  width: 50px;
  height: 50px;
  border-radius: 50%;
  background-color: #fff;
}

.cat::after {
  content: "";
  position: absolute;
  top: 10px;
  right: 20px;
  width: 50px;
  height: 50px;
  border-radius: 50%;
  background-color: #fff;
}

.cat .eyes {
  position: absolute;
  top: 25px;
  left: 35px;
  width: 20px;
  height: 20px;
  border-radius: 50%;
  background-color: #00f;
  transform: rotate(45deg);
}

.cat .eyes::before, .cat .eyes::after {
  content: "";
  position: absolute;
  top: 3px;
  width: 5px;
  height: 5px;
  border-radius: 50%;
  background-color: #fff;
}

.cat .eyes::before {
  left: 2px;
}

.cat .eyes::after {
  right: 2px;
}

.cat .nose {
  position: absolute;
  top: 45px;
  left: 60px;
  width: 30px;
  height: 20px;
  border-radius: 50%;
  background-color: #f00;
}

.cat .mouth {
  position: absolute;
  top: 60px;
  left: 45px;
  width: 60px;
  height: 25px;
  border-radius: 50% 50% 0 0;
  background-color: #fff;
  transform: rotate(-20deg);
  border-top: 2px solid #f00;
}
</style>

<div class="cat">
  <div class="eyes"></div>
  <div class="nose"></div>
  <div class="mouth"></div>
</div>

