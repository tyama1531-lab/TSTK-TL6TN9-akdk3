union() {
  difference() {
    import("case.stl");
    translate([75, 32, 6.5]) cube([30, 45, 10]); // 出っ張り削除
  }

  // 補完形状をZ軸まわりに45度回転して配置
  color("red")
  translate([112.730, 15.564, 5.5])//5.3
  rotate([0, 0, 117.48])
  cube([58, 5, 1.0]);//1.2
  
  translate([112.730, 15.564, 3.5])
  rotate([0, 0, 117.48])
  cube([30, 1.748, 3]);
    
  translate([110.6810, 13.214, 4.5])
  rotate([0, 0, 12.21])
  cube([2.5, 1.8631, 2.0]);
}