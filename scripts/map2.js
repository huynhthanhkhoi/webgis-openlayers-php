var map;
var draw, vector_measure, helpTooltip, measureTooltipElement;
var overlay, closer;
var vector_zoom2bbox, vector_addmarker;
var Point, vectorLayer_LonLat, vector_buffer;
var vector_stylemarker, vector_kgianmarker;

// Delete All
function clear_all() {
    // Đo lường
    map.removeInteraction(draw);
    if (vector_measure) { vector_measure.getSource().clear(); }
    map.removeOverlay(helpTooltip);
    if (measureTooltipElement) {
        var elem = document.getElementsByClassName("tooltip tooltip-static");

        for (var i = elem.length - 1; i >= 0; i--) {
            elem[i].remove();
        }
    }
    // End Đo lường

    // Lấy thông tin
    overlay.setPosition(undefined);
    closer.blur();
    $("#info").empty();
    // End Lấy thông tin

    // Lấy tọa độ tìm kiếm xung quanh
    if (vectorLayer_LonLat) {
        Point.setGeometry(null);
    }
    if (vector_buffer) { vector_buffer.getSource().clear(); }
    // End Lấy tọa độ tìm kiếm xung quanh

    // Tìm kiếm không gian
    if (vector_zoom2bbox) { vector_zoom2bbox.getSource().clear(); }
    // End Tìm kiếm không gian

    // Tìm kiếm thuộc tính, cơ bản
    if (vector_addmarker) { vector_addmarker.getSource().clear(); }
    // End Tìm kiếm thuộc tính, cơ bản
}
// End Delete All

// Xóa kết quả tìm kiếm
function delete_result() {
    $("#kq_tknangcao").empty();
    $("#kq_tkgian").empty();

    $("#kq_xquanh").empty();
    $("#txtLon").val(null);
    $("#txtLat").val(null);

    history.go(0);
}
// End Xóa kết quả tìm kiếm

// Đi tới khu vực
function zoomPanbbox(a, b, c, d) {
    var ext_zoom2bbox = [a, b, c, d];

    ext_zoom2bbox = ol.extent.applyTransform(ext_zoom2bbox, ol.proj.getTransform("EPSG:4326", "EPSG:4326"));

    map.getView().fit(ext_zoom2bbox, { size: map.getSize(), duration: 800 })
}
// End Đi tới khu vực

// Zoom tới khu vực
function zoom2bbox(a, b, c, d) {
    if (vector_zoom2bbox) { vector_zoom2bbox.getSource().clear(); }
    var ext_zoom2bbox = [a, b, c, d];

    ext_zoom2bbox = ol.extent.applyTransform(ext_zoom2bbox, ol.proj.getTransform("EPSG:4326", "EPSG:4326"));

    vector_zoom2bbox = new ol.layer.Vector({
        source: new ol.source.Vector({
            features: [new ol.Feature({
                geometry: new ol.geom.Polygon.fromExtent(ext_zoom2bbox),
            })]
        }),
        style: new ol.style.Style({
            stroke: new ol.style.Stroke({
                color: 'blue'
            }),
            fill: new ol.style.Fill({
                color: '#0000ff1a'
            })
        })
    });

    map.addLayer(vector_zoom2bbox);

    map.getView().fit(ext_zoom2bbox, { size: map.getSize(), duration: 800 })
}
// End zoom tới khu vực

// Tìm kiếm nhà trọ cơ bản
function timkiem() {
    var txtTieuChi = document.getElementById("txtTieuChi").value;
    var txtKhuVuc = document.getElementById("txtKhuVuc").value;

    if (window.XMLHttpRequest) {
        // Code for IE7+, Firefox, Chrome, Opera, Safari 
        xmlhttp = new XMLHttpRequest();
    } else {
        // Code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            document.getElementById("divkq").innerHTML = xmlhttp.responseText;
        }
    }
    xmlhttp.open("GET", "xltimkiem.php?tieuchi=" + txtTieuChi + "&khuvuc=" + txtKhuVuc, true);
    xmlhttp.send();
}
// End Tìm kiếm nhà trọ cơ bản

// Tìm kiếm nhà trọ nâng cao
function tknangcao() {
    var txtTenDuong = document.getElementById("txtTenDuong").value;
    var txtPhuongXa = document.getElementById("txtPhuongXa").value;
    var txtLPhong = document.getElementById("txtLPhong").value;
    var txtDienTich = document.getElementById("txtDienTich").value;
    var txtGPhong = document.getElementById("txtGPhong").value;
    var txtSLNguoi = document.getElementById("txtSLNguoi").value;
    var txtGDien = document.getElementById("txtGDien").value;
    var txtGNuoc = document.getElementById("txtGNuoc").value;
    var txtGioGiac = document.getElementById("txtGioGiac").value;
    var txtNVS = document.getElementById("txtNVS").value;

    if (window.XMLHttpRequest) {
        // Code for IE7+, Firefox, Chrome, Opera, Safari 
        xmlhttp = new XMLHttpRequest();
    } else {
        // Code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            document.getElementById("kq_tknangcao").innerHTML = xmlhttp.responseText;
        }
    }
    xmlhttp.open("GET", "xltk_nangcao.php?tduong=" + txtTenDuong + "&lphong=" + txtLPhong +
        "&phuongxa=" + txtPhuongXa + "&dtich=" + txtDienTich + "&gphong=" + txtGPhong +
        "&slnguoi=" + txtSLNguoi + "&gdien=" + txtGDien + "&gnuoc=" +
        txtGNuoc + "&ggiac=" + txtGioGiac + "&nvs=" + txtNVS, true);
    xmlhttp.send();
}
// End Tìm kiếm nhà trọ nâng cao

// Tìm kiếm không gian
function tkgian() {
    var xaphuong = document.getElementById("xaphuong").value;
    var txtKG = document.getElementById("txtKG").value;
    var txtBK = document.getElementById("txtBanKinh").value;
    var txtTR;

    if (txtKG == 'trhoc') {
        txtTR = document.getElementById("txtTR").value;
    } else {
        txtTR = null;
    }

    var txtTenDuong = document.getElementById("txtTenDuongKG").value;
    var txtLPhong = document.getElementById("txtLPhongKG").value;
    var txtDienTich = document.getElementById("txtDienTichKG").value;
    var txtGPhong = document.getElementById("txtGPhongKG").value;
    var txtSLNguoi = document.getElementById("txtSLNguoiKG").value;
    var txtGDien = document.getElementById("txtGDienKG").value;
    var txtGNuoc = document.getElementById("txtGNuocKG").value;
    var txtGioGiac = document.getElementById("txtGioGiacKG").value;
    var txtNVS = document.getElementById("txtNVSKG").value;

    if (window.XMLHttpRequest) {
        // Code for IE7+, Firefox, Chrome, Opera, Safari 
        xmlhttp = new XMLHttpRequest();
    } else {
        // Code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            document.getElementById("kq_tkgian").innerHTML = xmlhttp.responseText;
        }
    }
    xmlhttp.open("GET", "xltk_kgian.php?xp=" + xaphuong + "&lchon=" + txtKG + "&bkinh=" + txtBK + "&tentr=" + txtTR +
        "&tduong=" + txtTenDuong + "&lphong=" + txtLPhong +
        "&dtich=" + txtDienTich + "&gphong=" + txtGPhong + "&slnguoi=" + txtSLNguoi +
        "&gdien=" + txtGDien + "&gnuoc=" + txtGNuoc + "&ggiac=" + txtGioGiac + "&nvs=" + txtNVS, true);
    xmlhttp.send();
}
// End tìm kiếm không gian

// Tìm kiếm xung quanh
function tkxquanh() {
    var txtXQ = document.getElementById("txtXQ").value;
    var txtBanKinhXQ = document.getElementById("txtBanKinhXQ").value;
    var txtLon = document.getElementById("txtLon").value;
    var txtLat = document.getElementById("txtLat").value;

    if (txtXQ == 'ntro') {
        var txtTenDuong = document.getElementById("txtTenDuongXQ").value;
        var txtLPhong = document.getElementById("txtLPhongXQ").value;
        var txtDienTich = document.getElementById("txtDienTichXQ").value;
        var txtGPhong = document.getElementById("txtGPhongXQ").value;
        var txtSLNguoi = document.getElementById("txtSLNguoiXQ").value;
        var txtGDien = document.getElementById("txtGDienXQ").value;
        var txtGNuoc = document.getElementById("txtGNuocXQ").value;
        var txtGioGiac = document.getElementById("txtGioGiacXQ").value;
        var txtNVS = document.getElementById("txtNVSXQ").value;
    }

    if (window.XMLHttpRequest) {
        // Code for IE7+, Firefox, Chrome, Opera, Safari 
        xmlhttp = new XMLHttpRequest();
    } else {
        // Code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            document.getElementById("kq_xquanh").innerHTML = xmlhttp.responseText;
        }
    }
    xmlhttp.open("GET", "xltk_xquanh.php?kv=" + txtXQ + "&bkinh=" + txtBanKinhXQ + "&lon=" + txtLon + "&lat=" + txtLat +
        "&tduong=" + txtTenDuong + "&lphong=" + txtLPhong +
        "&dtich=" + txtDienTich + "&gphong=" + txtGPhong + "&slnguoi=" + txtSLNguoi +
        "&gdien=" + txtGDien + "&gnuoc=" + txtGNuoc + "&ggiac=" + txtGioGiac + "&nvs=" + txtNVS, true);
    xmlhttp.send();
}
// End tìm kiếm xung quanh

// Thêm marker khi nhấn zoom
function addmarker(lon, lat) {
    if (vector_addmarker) { vector_addmarker.getSource().clear(); }

    vector_addmarker = new ol.layer.Vector({
        source: new ol.source.Vector({
            features: [new ol.Feature({
                geometry: new ol.geom.Point(ol.proj.transform([parseFloat(lon), parseFloat(lat)], 'EPSG:4326', 'EPSG:4326')),
            })]
        }),
        style: new ol.style.Style({
            image: new ol.style.Icon({
                anchor: [0.5, 0.5],
                anchorXUnits: "fraction",
                anchorYUnits: "fraction",
                src: "images/marker.png"
            }),
        })
    });

    map.addLayer(vector_addmarker);

    // setTimeout(function () {
    //     map.removeLayer(vector_addmarker);
    // }, 5000);

    var ext_addmarker = vector_addmarker.getSource().getExtent();
    map.getView().fit(ext_addmarker, { size: map.getSize(), maxZoom: 16, duration: 800 })
}
// End Thêm marker khi nhấn zoom

$("#document").ready(function() {
    /**
     * Các yếu tố tạo nên cửa sổ bật lên.
     */
    var container = document.getElementById('popup');
    var content = document.getElementById('popup-content');
    closer = document.getElementById('popup-closer');

    /**
     * Tạo lớp phủ để cố định cửa sổ bật lên vào bản đồ.
     */
    overlay = new ol.Overlay({
        element: container,
        autoPan: true,
        autoPanAnimation: {
            duration: 250,
        },
    });

    /**
     * Thêm một trình xử lý nhấp chuột để ẩn cửa sổ bật lên.
     * @return {boolean} Đừng làm theo href.
     */
    closer.onclick = function() {
        overlay.setPosition(undefined);
        closer.blur();
        return false;
    };

    var format = 'image/png';

    // Định nghĩa đường bao của các lớp layers
    var wards = [109.111190795898, 12.1408491134644,
        109.371650695801, 12.3797512054443
    ];

    var road = [109.119430541992, 12.1422233581543,
        109.334037780762, 12.3777923583984
    ];

    var motel = [109.178504943848, 12.2653818130493,
        109.203750610352, 12.2863569259644
    ];

    var utilities = [109.128479003906, 12.1907749176025,
        109.211807250977, 12.3342332839966
    ];

    var school = [109.177574157715, 12.216742515564,
        109.207008361816, 12.2970743179321
    ];

    var busstop = [109.134574890137, 12.1669702529907,
        109.214973449707, 12.375714302063
    ];

    var city = [109.111190795898, 12.14084815979,
        109.371658325195, 12.37975025177
    ];
    // End Định nghĩa đường bao của các lớp layers

    // Mouse location
    var mousePositionControl = new ol.control.MousePosition({
        className: 'custom-mouse-position',
        // target: document.getElementById('location'),
        coordinateFormat: ol.coordinate.createStringXY(6),
        undefinedHTML: '&nbsp;'
    });
    // End Mouse location

    // Định nghĩa các lớp layers
    var TramBus = new ol.layer.Image({
        minZoom: 12,
        source: new ol.source.ImageWMS({
            ratio: 1,
            url: 'http://localhost:8080/geoserver/webgis/wms',
            params: {
                'FORMAT': format,
                'VERSION': '1.1.1',
                "STYLES": '',
                "LAYERS": 'webgis:trambus',
                "exceptions": 'application/vnd.ogc.se_inimage',
            },
            crossOrigin: 'Anonymous',
            // remove this function config if the tile's src is nothing to decorate. It's usually to debug the src
            tileLoadFunction: function(tile, src) {
                tile.getImage().src = src
            }
        })
    });

    var Truong = new ol.layer.Image({
        minZoom: 12,
        source: new ol.source.ImageWMS({
            ratio: 1,
            url: 'http://localhost:8080/geoserver/webgis/wms',
            params: {
                'FORMAT': format,
                'VERSION': '1.1.1',
                "STYLES": '',
                "LAYERS": 'webgis:truong',
                "exceptions": 'application/vnd.ogc.se_inimage',
            },
            crossOrigin: 'Anonymous',
            // remove this function config if the tile's src is nothing to decorate. It's usually to debug the src
            tileLoadFunction: function(tile, src) {
                tile.getImage().src = src
            }
        })
    });

    var TienIch = new ol.layer.Image({
        source: new ol.source.ImageWMS({
            ratio: 1,
            url: 'http://localhost:8080/geoserver/webgis/wms',
            params: {
                'FORMAT': format,
                'VERSION': '1.1.1',
                "STYLES": '',
                "LAYERS": 'webgis:tienich',
                "exceptions": 'application/vnd.ogc.se_inimage',
            },
            crossOrigin: 'Anonymous',
            // remove this function config if the tile's src is nothing to decorate. It's usually to debug the src
            tileLoadFunction: function(tile, src) {
                tile.getImage().src = src
            }
        })
    });

    var NhaTro = new ol.layer.Image({
        minZoom: 11,
        source: new ol.source.ImageWMS({
            ratio: 1,
            url: 'http://localhost:8080/geoserver/webgis/wms',
            params: {
                'FORMAT': format,
                'VERSION': '1.1.1',
                "STYLES": '',
                "LAYERS": 'webgis:nhatro',
                "exceptions": 'application/vnd.ogc.se_inimage',
            },
            crossOrigin: 'Anonymous',
            // remove this function config if the tile's src is nothing to decorate. It's usually to debug the src
            tileLoadFunction: function(tile, src) {
                tile.getImage().src = src
            }
        })
    });

    var Duong = new ol.layer.Image({
        minZoom: 11,
        source: new ol.source.ImageWMS({
            ratio: 1,
            url: 'http://localhost:8080/geoserver/webgis/wms',
            params: {
                'FORMAT': format,
                'VERSION': '1.1.1',
                "STYLES": '',
                "LAYERS": 'webgis:duong',
                "exceptions": 'application/vnd.ogc.se_inimage',
            },
            crossOrigin: 'Anonymous',
            // remove this function config if the tile's src is nothing to decorate. It's usually to debug the src
            tileLoadFunction: function(tile, src) {
                tile.getImage().src = src
            }
        })
    });

    var XaPhuong = new ol.layer.Image({
        minZoom: 10,
        source: new ol.source.ImageWMS({
            ratio: 1,
            url: 'http://localhost:8080/geoserver/webgis/wms',
            params: {
                'FORMAT': format,
                'VERSION': '1.1.1',
                "STYLES": '',
                "LAYERS": 'webgis:xaphuong',
                "exceptions": 'application/vnd.ogc.se_inimage',
            },
            crossOrigin: 'Anonymous',
            // remove this function config if the tile's src is nothing to decorate. It's usually to debug the src
            tileLoadFunction: function(tile, src) {
                tile.getImage().src = src
            }
        })
    });

    var ThanhPho = new ol.layer.Image({
        source: new ol.source.ImageWMS({
            ratio: 1,
            url: 'http://localhost:8080/geoserver/webgis/wms',
            params: {
                'FORMAT': format,
                'VERSION': '1.1.1',
                "STYLES": '',
                "LAYERS": 'webgis:thanhpho',
                "exceptions": 'application/vnd.ogc.se_inimage',
            },
            crossOrigin: 'Anonymous',
            // remove this function config if the tile's src is nothing to decorate. It's usually to debug the src
            tileLoadFunction: function(tile, src) {
                tile.getImage().src = src
            }
        })
    });
    // End Định nghĩa các lớp layers

    // Định nghĩa tọa độ, hệ quy chiếu WGS84
    var projection = new ol.proj.Projection({
        code: 'EPSG:4326',
        units: 'degrees',
        axisOrientation: 'neu'
    });
    // End Định nghĩa tọa độ, hệ quy chiếu WGS84

    // Bar scale
    var scaleBarSteps = 4;
    var scaleBarText = true;
    var control;

    function scaleControl() {
        control = new ol.control.ScaleLine({
            units: 'metric',
            bar: true,
            steps: scaleBarSteps,
            text: scaleBarText,
            minWidth: 140,
        });
        return control;
    }
    // End Bar scale

    // Chồng các lớp layers vào Map
    var view = new ol.View({
        projection: projection
    });

    map = new ol.Map({
        controls: ol.control.defaults({
            attribution: false
        }).extend([mousePositionControl, scaleControl(), new ol.control.FullScreen({
            source: 'fullscreen',
            label: 'F'
        })]),
        interactions: ol.interaction.defaults().extend([new ol.interaction.DragRotateAndZoom()]),
        overlays: [overlay],
        target: 'map',
        loadTilesWhileAnimating: true,
        layers: [
            new ol.layer.Tile({
                title: 'OSM',
                type: 'base',
                visible: true,
                source: new ol.source.OSM()
            }),
            ThanhPho,
            XaPhuong,
            Duong,
            TramBus,
            TienIch,
            Truong,
            NhaTro
        ],
        view: new ol.View({
            projection: projection,
            center: [0, 0],
            zoom: 2,
            maxZoom: 23,
            minZoom: 7,
        })
    });
    // End Chồng các lớp layers vào Map

    // Map Export PNG
    document.getElementById('export-png').addEventListener('click', function() {
        map.once('rendercomplete', function() {
            var mapCanvas = document.createElement('canvas');
            var size = map.getSize();
            mapCanvas.width = size[0];
            mapCanvas.height = size[1];
            var mapContext = mapCanvas.getContext('2d');
            Array.prototype.forEach.call(
                document.querySelectorAll('.ol-layer canvas'),
                function(canvas) {
                    if (canvas.width > 0) {
                        var opacity = canvas.parentNode.style.opacity;
                        mapContext.globalAlpha = opacity === '' ? 1 : Number(opacity);
                        var transform = canvas.style.transform;
                        // Get the transform parameters from the style's transform matrix
                        var matrix = transform
                            .match(/^matrix\(([^\(]*)\)$/)[1]
                            .split(',')
                            .map(Number);
                        // Apply the transform to the export map context
                        CanvasRenderingContext2D.prototype.setTransform.apply(
                            mapContext,
                            matrix
                        );
                        mapContext.drawImage(canvas, 0, 0);
                    }
                }
            );
            if (navigator.msSaveBlob) {
                // link download attribuute does not work on MS browsers
                navigator.msSaveBlob(mapCanvas.msToBlob(), 'map.png');
            } else {
                var link = document.getElementById('image-download');
                link.href = mapCanvas.toDataURL();
                link.click();
            }
        });
        map.renderSync();
    });
    // End Map Export PNG

    // Map Export PDF
    var dims = {
        a0: [1189, 841],
        a1: [841, 594],
        a2: [594, 420],
        a3: [420, 297],
        a4: [297, 210],
        a5: [210, 148],
    };

    var exportButton = document.getElementById('export-pdf');

    exportButton.addEventListener(
        'click',
        function() {
            exportButton.disabled = true;
            document.body.style.cursor = 'progress';

            var format = document.getElementById('format').value;
            var resolution = document.getElementById('resolution').value;
            var dim = dims[format];
            var width = Math.round((dim[0] * resolution) / 25.4);
            var height = Math.round((dim[1] * resolution) / 25.4);
            var size = map.getSize();
            var viewResolution = map.getView().getResolution();

            map.once('rendercomplete', function() {
                var mapCanvas = document.createElement('canvas');
                mapCanvas.width = width;
                mapCanvas.height = height;
                var mapContext = mapCanvas.getContext('2d');
                Array.prototype.forEach.call(
                    document.querySelectorAll('.ol-layer canvas'),
                    function(canvas) {
                        if (canvas.width > 0) {
                            var opacity = canvas.parentNode.style.opacity;
                            mapContext.globalAlpha = opacity === '' ? 1 : Number(opacity);
                            var transform = canvas.style.transform;
                            // Get the transform parameters from the style's transform matrix
                            var matrix = transform
                                .match(/^matrix\(([^\(]*)\)$/)[1]
                                .split(',')
                                .map(Number);
                            // Apply the transform to the export map context
                            CanvasRenderingContext2D.prototype.setTransform.apply(
                                mapContext,
                                matrix
                            );
                            mapContext.drawImage(canvas, 0, 0);
                        }
                    }
                );
                var pdf = new jsPDF('landscape', undefined, format);
                pdf.addImage(
                    mapCanvas.toDataURL('image/jpeg'),
                    'JPEG',
                    0,
                    0,
                    dim[0],
                    dim[1]
                );
                pdf.save('map.pdf');
                // Reset original map size
                map.setSize(size);
                map.getView().setResolution(viewResolution);
                exportButton.disabled = false;
                document.body.style.cursor = 'auto';
            });

            // Set print size
            var printSize = [width, height];
            map.setSize(printSize);
            var scaling = Math.min(width / size[0], height / size[1]);
            map.getView().setResolution(viewResolution / scaling);
        },
        false
    );
    // End Map Export PDF

    // Overview map
    var OSM = new ol.layer.Tile({
        source: new ol.source.OSM(),
        type: 'base',
        title: 'OSM',
    });

    var view_ov = new ol.View({
        projection: 'EPSG:4326',
        center: [78.0, 23.0],
        zoom: 5,
    });

    var overview = new ol.control.OverviewMap({
        view: view_ov,
        collapseLabel: 'O',
        label: 'O',
        layers: [OSM]
    });

    map.addControl(overview);
    // End Overview map

    // Zoom to extent map TPNT
    var zoom_ex = new ol.control.ZoomToExtent({
        extent: [
            109.11119079589844, 12.140848159790039,
            109.37165832519531, 12.379751205444336
        ]
    });
    map.addControl(zoom_ex);
    // End Zoom to extent map TPNT

    // Highlight đối tượng
    var styles = {
        'MultiPolygon': new ol.style.Style({
            stroke: new ol.style.Stroke({
                color: 'yellow',
                width: 2
            })
        }),
        'MultiLineString': new ol.style.Style({
            stroke: new ol.style.Stroke({
                color: 'yellow',
                width: 2
            })
        }),
        'MultiPoint': new ol.style.Style({
            stroke: new ol.style.Stroke({
                color: 'yellow',
                width: 2
            })
        }),
        'GeometryCollection': new ol.style.Style({
            stroke: new ol.style.Stroke({
                color: 'yellow',
                width: 2
            })
        }),
        'Feature': new ol.style.Style({
            stroke: new ol.style.Stroke({
                color: 'yellow',
                width: 2
            })
        }),
        'FeatureCollection': new ol.style.Style({
            stroke: new ol.style.Stroke({
                color: 'yellow',
                width: 2
            })
        }),
        'fill': new ol.style.Fill({
            color: 'rgba(255, 255, 255, 0.7)'
        }),
        'stroke': new ol.style.Stroke({
            color: '#ffcc33',
            width: 3
        }),
        'image': new ol.style.Circle({
            radius: 7,
            fill: new ol.style.Fill({
                color: '#ffcc33'
            })
        })
    };

    var styleFunction = function(feature) {
        return styles[feature.getGeometry().getType()];
    };
    var vectorLayer_Highlight = new ol.layer.Vector({
        style: styleFunction
    });
    map.addLayer(vectorLayer_Highlight);
    // End Highlight đối tượng

    // Thanh zoom
    var zoomslider = new ol.control.ZoomSlider();
    map.addControl(zoomslider);
    // End Thanh zoom

    map.getView().getCenter();
    map.getView().fit(wards, map.getSize());
    map.getView().fit(road, map.getSize());
    map.getView().fit(utilities, map.getSize());
    map.getView().fit(motel, map.getSize());
    map.getView().fit(school, map.getSize());
    map.getView().fit(busstop, map.getSize());
    map.getView().fit(city, map.getSize());

    // Show the user's location
    const locate = document.createElement('div');
    locate.className = 'ol-control ol-unselectable locate';
    locate.innerHTML = '<button title="Locate me">◎</button>';
    locate.addEventListener('click', function() {
        if (!source_locate.isEmpty()) {
            map.getView().fit(source_locate.getExtent(), {
                maxZoom: 16,
                duration: 800
            });
        }
    });
    map.addControl(new ol.control.Control({
        element: locate
    }));

    var geolocation = new ol.Geolocation({
        // enableHighAccuracy phải được đặt thành true để có giá trị.
        trackingOptions: {
            enableHighAccuracy: true,
        },
        projection: view.getProjection(),
    });

    function el(id) {
        return document.getElementById(id);
    }

    el('track').addEventListener('change', function() {
        geolocation.setTracking(this.checked);
    });

    // xử lý lỗi vị trí địa lý.
    geolocation.on('error', function(error) {
        var info = document.getElementById('info');
        info.innerHTML = error.message;
        info.style.display = '';
    });

    var accuracyFeature = new ol.Feature();
    geolocation.on('change:accuracyGeometry', function() {
        accuracyFeature.setGeometry(geolocation.getAccuracyGeometry());
    });

    var positionFeature = new ol.Feature();
    positionFeature.setStyle(
        new ol.style.Style({
            image: new ol.style.Circle({
                radius: 6,
                fill: new ol.style.Fill({
                    color: '#3399CC',
                }),
                stroke: new ol.style.Stroke({
                    color: '#fff',
                    width: 2,
                }),
            }),
        })
    );

    geolocation.on('change:position', function() {
        var coordinates = geolocation.getPosition();
        positionFeature.setGeometry(coordinates ? new ol.geom.Point(coordinates) : null);
    });

    var source_locate = new ol.source.Vector({
        features: [accuracyFeature, positionFeature],
    });

    const layer_locate = new ol.layer.Vector({
        source: source_locate
    });

    $('#track').on('click', function() {
        var isChecked = $(this).is(':checked');
        if (isChecked) {
            map.addLayer(layer_locate);
            setTimeout(function() {
                if (!source_locate.isEmpty()) {
                    map.getView().fit(source_locate.getExtent(), {
                        maxZoom: 16,
                        duration: 800
                    });
                };
            }, 1000);
        } else {
            map.removeLayer(layer_locate);
        }
    });
    // End Show the user's location

    // Highlight tìm kiếm không gian
    $("#btkgian").on('click', function() {
        var lon, lat;

        setTimeout(function() {
            var elem = document.getElementsByClassName("number_kgian");
            var i;

            for (i = 1; i <= elem.length; i++) {
                lon = document.getElementById("long_kgian[" + i + "]").value;
                lat = document.getElementById("lat_kgian[" + i + "]").value;

                vector_kgianmarker = new ol.layer.Vector({
                    source: new ol.source.Vector({
                        features: [new ol.Feature({
                            geometry: new ol.geom.Point(ol.proj.transform([parseFloat(lon), parseFloat(lat)], "EPSG:4326", "EPSG:4326")),
                        })]
                    }),
                    style: new ol.style.Style({
                        image: new ol.style.Icon({
                            anchor: [0.5, 0.4],
                            anchorXUnits: "fraction",
                            anchorYUnits: "fraction",
                            src: "images/circle2.png"
                        }),
                    })
                });

                map.addLayer(vector_kgianmarker);
            }
        }, 2000);
    });
    // End Highlight tìm kiếm không gian

    // Lấy tọa độ tìm kiếm xung quanh
    Point = new ol.Feature();

    vectorLayer_LonLat = new ol.layer.Vector({
        source: new ol.source.Vector({
            features: [Point]
        })
    });

    map.addLayer(vectorLayer_LonLat);

    function lonlat(evt) {
        if (Point.getGeometry() == null) {
            // First click.
            Point.setGeometry(new ol.geom.Point(evt.coordinate));
            $("#txtLon").val(evt.coordinate[0]);
            $("#txtLat").val(evt.coordinate[1]);
        }
    }

    $("#chkLonLat").on('click', function() {
        var isChecked = $(this).is(':checked');
        if (isChecked) {
            map.on('singleclick', lonlat);
        } else {
            map.un('singleclick', lonlat);
        }
    });

    $("#btxquanh").on('click', function() {
        var wkt, lon, lat;

        // Vẽ bán kính
        if (vector_buffer) { vector_buffer.getSource().clear(); }
        setTimeout(function() {
            wkt = document.getElementById("geometry").value;
            var format = new ol.format.WKT();

            var feature = format.readFeature(wkt, {
                dataProjection: 'EPSG:4326',
                featureProjection: 'EPSG:4326',
            });

            vector_buffer = new ol.layer.Vector({
                source: new ol.source.Vector({
                    features: [feature],
                }),
            });

            map.addLayer(vector_buffer);
            vector_buffer2 = vector_buffer.getSource().getExtent();
            map.getView().fit(vector_buffer2, { size: map.getSize(), maxZoom: 16, duration: 800 });
        }, 2000);

        // Highlight đối tượng tìm được
        setTimeout(function() {
            var elem = document.getElementsByClassName("number");
            var i;

            for (i = 1; i <= elem.length; i++) {
                lon = document.getElementById("longitude[" + i + "]").value;
                lat = document.getElementById("latitude[" + i + "]").value;

                vector_stylemarker = new ol.layer.Vector({
                    source: new ol.source.Vector({
                        features: [new ol.Feature({
                            geometry: new ol.geom.Point(ol.proj.transform([parseFloat(lon), parseFloat(lat)], "EPSG:4326", "EPSG:4326")),
                        })]
                    }),
                    style: new ol.style.Style({
                        image: new ol.style.Icon({
                            anchor: [0.5, 0.4],
                            anchorXUnits: "fraction",
                            anchorYUnits: "fraction",
                            src: "images/circle2.png"
                        }),
                    })
                });

                map.addLayer(vector_stylemarker);
            }
        }, 2000);
    });
    // End Lấy tọa độ tìm kiếm xung quanh

    // Tìm đường đi
    var startPoint = new ol.Feature();
    var destPoint = new ol.Feature();

    var vectorLayer_RoadFind = new ol.layer.Vector({
        source: new ol.source.Vector({
            features: [startPoint, destPoint]
        })
    });

    map.addLayer(vectorLayer_RoadFind);

    function roadfind(evt) {
        if (startPoint.getGeometry() == null) {
            // First click.
            startPoint.setGeometry(new ol.geom.Point(evt.coordinate));
            $("#txtPoint1").val(evt.coordinate);
        } else if (destPoint.getGeometry() == null) {
            // Second click.
            destPoint.setGeometry(new ol.geom.Point(evt.coordinate));
            $("#txtPoint2").val(evt.coordinate);
        }
    }

    $("#btnSolve").click(function() {
        var startCoord = startPoint.getGeometry().getCoordinates();
        var destCoord = destPoint.getGeometry().getCoordinates();
        var params = {
            LAYERS: 'webgis:route',
            FORMAT: 'image/png'
        };
        var viewparams = [
            'x1:' + startCoord[0], 'y1:' + startCoord[1],
            'x2:' + destCoord[0], 'y2:' + destCoord[1]
        ];
        params.viewparams = viewparams.join(';');
        result_RoadFind = new ol.layer.Image({
            source: new ol.source.ImageWMS({
                url: 'http://localhost:8080/geoserver/webgis/wms',
                params: params
            })
        });

        map.addLayer(result_RoadFind);
    });

    $("#btnReset").click(function() {
        $("#txtPoint1").val(null);
        $("#txtPoint2").val(null);
        startPoint.setGeometry(null);
        destPoint.setGeometry(null);
        // Remove the result layer.
        map.removeLayer(result_RoadFind);
    });

    $("#chkRoadFind").on('click', function() {
        var isChecked = $(this).is(':checked');
        if (isChecked) {
            map.on('singleclick', roadfind);
        } else {
            // history.go(0);
            map.un('singleclick', roadfind);
        }
    });
    // End Tìm đường đi

    // Singleclick Nhà trọ
    function getinfo_nhatro(evt) {
        document.getElementById('info').innerHTML = 'Đang tải...Vui lòng đợi...';
        var view_motel = map.getView();
        var wmsSource_motel = NhaTro.getSource();
        var viewResolution_motel = /** @type {number} */ (view_motel.getResolution());
        var url = wmsSource_motel.getFeatureInfoUrl(
            evt.coordinate,
            viewResolution_motel,
            'EPSG:4326', { 'INFO_FORMAT': 'application/json' }
        );
        if (url) {
            $.ajax({
                type: "POST",
                url: url,
                contentType: "application/json; charset=utf-8",
                dataType: 'json',
                success: function(n) {
                    var content_motel = "<table class='table table-bordered'>";
                    for (var i = 0; i < n.features.length; i++) {
                        var feature = n.features[i];
                        var featureAttr = feature.properties;
                        content_motel += "<tr><th>Diện tích</th><th>Số người ở tối đa</th><th>Nhà vệ sinh</th><th>Giá phòng</th>" +
                            "<th>Tiền cọc</th><th>Tiền điện</th><th>Tiền nước</th><th>Giờ giấc</th>" +
                            "<th>SL phòng trống</th><th>Liên hệ</th></tr><tr>" +
                            "<td>" + featureAttr["dientich"] + "m2</td><td>" +
                            featureAttr["songuoio"] + "</td><td>" + featureAttr["nhavesinh"] + "</td><td>" +
                            parseInt(featureAttr["giaphong"]).toLocaleString() + "đ/tháng</td><td>" + parseInt(featureAttr["tiencoc"]).toLocaleString() + "đ</td><td>" +
                            parseInt(featureAttr["tiendien"]).toLocaleString() + "đ/1 kWh</td><td>" + parseInt(featureAttr["tiennuoc"]).toLocaleString() + "đ/m3</td><td>" +
                            featureAttr["giogiac"] + "</td><td>" + featureAttr["slphongtro"] + "</td>" +
                            "<td>" + featureAttr["sdt"] + "</td></tr>"
                    }
                    content_motel += "</table>";

                    var content_motel1 = "<table border='0' class='popup2'>";
                    for (var i = 0; i < n.features.length; i++) {
                        var feature = n.features[i];
                        var featureAttr = feature.properties;
                        content_motel1 += "<tr><td><b>Diện tích: </b>" + featureAttr["dientich"] + "m2</td></tr>" +
                            "<tr><td><b>Số người ở tối đa: </b>" + featureAttr["songuoio"] + "</td></tr>" +
                            "<tr><td><b>Nhà vệ sinh: </b>" + featureAttr["nhavesinh"] + "</td></tr>" +
                            "<tr><td><b>Giá phòng: </b>" + parseInt(featureAttr["giaphong"]).toLocaleString() + "đ</td></tr>" +
                            "<tr><td><b>Giờ giấc: </b>" + featureAttr["giogiac"] + "</td></tr>" +
                            "<tr><td><b>Số lượng phòng trống: </b>" + featureAttr["slphongtro"] + "</td></tr>"
                    }
                    content_motel1 += "</table>";
                    $("#info").html(content_motel);
                    $("#popup-content").html(content_motel1);
                    overlay.setPosition(evt.coordinate);

                    var vectorSource_motel = new ol.source.Vector({
                        features: (new ol.format.GeoJSON()).readFeatures(n)
                    });

                    vectorLayer_Highlight.setSource(vectorSource_motel);
                }
            });
        }
    }
    // End Singleclick Nhà trọ

    // Singleclick Tiện ích
    function getinfo_tienich(evt) {
        var view_utis = map.getView();
        var wmsSource_utis = TienIch.getSource();
        var viewResolution_utis = /** @type {number} */ (view_utis.getResolution());
        var url = wmsSource_utis.getFeatureInfoUrl(
            evt.coordinate,
            viewResolution_utis,
            'EPSG:4326', { 'INFO_FORMAT': 'application/json' }
        );
        if (url) {
            $.ajax({
                type: "POST",
                url: url,
                contentType: "application/json; charset=utf-8",
                dataType: 'json',
                success: function(n) {
                    var content_utis = "<table border='0' class='popup2'>";
                    for (var i = 0; i < n.features.length; i++) {
                        var feature = n.features[i];
                        var featureAttr = feature.properties;
                        content_utis += "<tr><td><b>" + featureAttr["tentienich"] + "</b></td></tr>" +
                            "<tr><td>Địa chỉ: " + featureAttr["sonha"] + "</td></tr>"
                    }
                    content_utis += "</table>";
                    $("#popup-content").html(content_utis);
                    overlay.setPosition(evt.coordinate);

                    var vectorSource_utis = new ol.source.Vector({
                        features: (new ol.format.GeoJSON()).readFeatures(n)
                    });

                    vectorLayer_Highlight.setSource(vectorSource_utis);
                }
            });
        }
    }
    // End Singleclick Tiện ích

    // Singleclick Trạm bus
    function getinfo_trambus(evt) {
        var view_bus = map.getView();
        var wmsSource_bus = TramBus.getSource();
        var viewResolution_bus = /** @type {number} */ (view_bus.getResolution());
        var url = wmsSource_bus.getFeatureInfoUrl(
            evt.coordinate,
            viewResolution_bus,
            'EPSG:4326', { 'INFO_FORMAT': 'application/json' }
        );
        if (url) {
            $.ajax({
                type: "POST",
                url: url,
                contentType: "application/json; charset=utf-8",
                dataType: 'json',
                success: function(n) {
                    var content_bus = "<table class='popup_bus'>";
                    for (var i = 0; i < n.features.length; i++) {
                        var feature = n.features[i];
                        var featureAttr = feature.properties;
                        content_bus += "<tr><td><b>" + featureAttr["tenbus"] + "</b></td></tr>"
                    }
                    content_bus += "</table>";
                    $("#popup-content").html(content_bus);
                    overlay.setPosition(evt.coordinate);

                    var vectorSource_bus = new ol.source.Vector({
                        features: (new ol.format.GeoJSON()).readFeatures(n)
                    });

                    vectorLayer_Highlight.setSource(vectorSource_bus);
                }
            });
        }
    }
    // End Singleclick Trạm bus

    // Activate_getinfo hoặc Deactivate_getinfo
    getinfotype.onchange = function() {
        map.removeInteraction(draw);
        if (vector_measure) { vector_measure.getSource().clear(); }
        map.removeOverlay(helpTooltip);
        if (measureTooltipElement) {
            var elem = document.getElementsByClassName("tooltip tooltip-static");

            for (var i = elem.length - 1; i >= 0; i--) {
                elem[i].remove();
                //alert(elem[i].innerHTML);
            }
        }

        if (getinfotype.value == 'activate_getinfo') {
            map.on('singleclick', getinfo_nhatro);
            map.on('singleclick', getinfo_tienich);
            map.on('singleclick', getinfo_trambus);
        } else if (getinfotype.value == 'select' || getinfotype.value == 'deactivate_getinfo') {
            map.un('singleclick', getinfo_nhatro);
            map.un('singleclick', getinfo_tienich);
            map.un('singleclick', getinfo_trambus);
            overlay.setPosition(undefined);
            closer.blur();
        }
    };
    // End Activate_getinfo hoặc Deactivate_getinfo

    // Pointermove Xã phường
    map.on('pointermove', function(evt) {
        var view_wards = map.getView();
        var wmsSource_wards = XaPhuong.getSource();
        var viewResolution_wards = /** @type {number} */ (view_wards.getResolution());
        var url = wmsSource_wards.getFeatureInfoUrl(
            evt.coordinate,
            viewResolution_wards,
            'EPSG:4326', { 'INFO_FORMAT': 'application/json' }
        );
        console.log(url, 'url');
        if (url) {
            $.ajax({
                type: "POST",
                url: url,
                contentType: "application/json; charset=utf-8",
                dataType: 'json',
                success: function(n) {
                    var vectorSource_wards = new ol.source.Vector({
                        features: (new ol.format.GeoJSON()).readFeatures(n)
                    });

                    vectorLayer_Highlight.setSource(vectorSource_wards);
                }
            });
        }
    });
    // End Pointermove Xã phường

    // Thay đổi con trỏ chuột khi qua điểm đánh dấu
    map.on('pointermove', function(evt) {
        if (evt.dragging) {
            return;
        }
        var pixel = map.getEventPixel(evt.originalEvent);
        var hit = map.forEachLayerAtPixel(pixel, function() {
            return true;
        });
        map.getTargetElement().style.cursor = hit ? 'pointer' : '';
    });
    // End Thay đổi con trỏ chuột khi qua điểm đánh dấu

    // Measure(đo lường) tool
    var source_measure = new ol.source.Vector();

    vector_measure = new ol.layer.Vector({
        source: source_measure,
        style: new ol.style.Style({
            fill: new ol.style.Fill({
                color: 'rgba(255, 255, 255, 0.2)'
            }),
            stroke: new ol.style.Stroke({
                color: '#ffcc33',
                width: 2
            }),
            image: new ol.style.Circle({
                radius: 7,
                fill: new ol.style.Fill({
                    color: '#ffcc33'
                })
            })
        })
    });

    map.addLayer(vector_measure);

    /**
     * Tính năng hiện đang được vẽ.
     * @type {module:ol/Feature~Feature}
     */
    var sketch;

    /**
     * Phần tử chú giải công cụ trợ giúp.
     * @type {Element}
     */
    var helpTooltipElement;

    /**
     * Lớp phủ để hiển thị các thông báo trợ giúp.
     * @type {module:ol/Overlay}
     */
    // var helpTooltip;

    /**
     * Phần tử chú giải công cụ đo lường.
     * @type {Element}
     */
    // var measureTooltipElement;

    /**
     * Lớp phủ để hiển thị phép đo.
     * @type {module:ol/Overlay}
     */
    var measureTooltip;

    /**
     * Thông báo hiển thị khi người dùng đang vẽ một đa giác.
     * @type {string}
     */
    var continuePolygonMsg = 'Nhấp để tiếp tục vẽ đa giác';

    /**
     * Thông báo hiển thị khi người dùng đang vẽ một đường thẳng.
     * @type {string}
     */
    var continueLineMsg = 'Nhấp để tiếp tục vẽ đường';

    // var draw; // biến vẽ toàn cục để có thể xóa nó sau

    /**
     * Định dạng đầu ra độ dài.
     * @param {module:ol/geom/LineString~LineString} line The line.
     * @return {string} Độ dài được định dạng.
     */
    var formatLength = function(line) {
        var length = ol.sphere.getLength(line, { projection: 'EPSG:4326' });

        var output;
        if (length > 1000) {
            output = Math.round((length / 1000) * 100) / 100 + ' ' + 'km';
        } else {
            output = Math.round(length * 100) / 100 + ' ' + 'm';
        }
        return output;
    };

    /**
     * Định dạng đầu ra khu vực.
     * @param {module:ol/geom/Polygon~Polygon} polygon The polygon.
     * @return {string}// Khu vực được định dạng.
     */
    var formatArea = function(polygon) {
        var area = ol.sphere.getArea(polygon, { projection: 'EPSG:4326' });

        var output;
        if (area > 10000) {
            output = Math.round((area / 10000) * 100) / 100 + ' ' + 'ha';
        } else {
            output = Math.round(area * 100) / 100 + ' ' + 'm<sup>2</sup>';
        }
        return output;
    };

    function addInteraction() {
        /**
         * Xử lý di chuyển con trỏ.
         * @param {module:ol/MapBrowserEvent~MapBrowserEvent} evt The event.
         */
        var pointerMoveHandler = function(evt) {
            if (evt.dragging) {
                return;
            }
            /** @type {string} */
            var helpMsg = 'Nhấp để bắt đầu vẽ';

            if (sketch) {
                var geom = (sketch.getGeometry());
                if (geom instanceof ol.geom.Polygon) {

                    helpMsg = continuePolygonMsg;
                } else if (geom instanceof ol.geom.LineString) {
                    helpMsg = continueLineMsg;
                }
            }

            helpTooltipElement.innerHTML = helpMsg;
            helpTooltip.setPosition(evt.coordinate);

            helpTooltipElement.classList.remove('hidden');
        };

        map.on('pointermove', pointerMoveHandler);

        map.getViewport().addEventListener('mouseout', function() {
            helpTooltipElement.classList.add('hidden');
        });
        /**
         * End Xử lý di chuyển con trỏ.
         * @param {module:ol/MapBrowserEvent~MapBrowserEvent} evt The event.
         */

        var type;
        if (measuretype.value == 'area') { type = 'Polygon'; } else if (measuretype.value == 'length') { type = 'LineString'; }

        draw = new ol.interaction.Draw({
            source: source_measure,
            type: type,
            style: new ol.style.Style({
                fill: new ol.style.Fill({
                    color: 'rgba(255, 255, 255, 0.5)'
                }),
                stroke: new ol.style.Stroke({
                    color: 'rgba(0, 0, 0, 0.5)',
                    lineDash: [10, 10],
                    width: 2
                }),
                image: new ol.style.Circle({
                    radius: 5,
                    stroke: new ol.style.Stroke({
                        color: 'rgba(0, 0, 0, 0.7)'
                    }),
                    fill: new ol.style.Fill({
                        color: 'rgba(255, 255, 255, 0.5)'
                    })
                })
            })
        });

        if (measuretype.value == 'select' || measuretype.value == 'clear') {
            map.removeInteraction(draw);
            if (vector_measure) { vector_measure.getSource().clear(); }
            map.removeOverlay(helpTooltip);

            if (measureTooltipElement) {
                var elem = document.getElementsByClassName("tooltip tooltip-static");

                for (var i = elem.length - 1; i >= 0; i--) {
                    elem[i].remove();
                }
            }
        } else if (measuretype.value == 'area' || measuretype.value == 'length') {
            map.addInteraction(draw);
            createMeasureTooltip();
            createHelpTooltip();

            var listener;
            draw.on('drawstart',
                function(evt) {
                    sketch = evt.feature;

                    /** @type {module:ol/coordinate~Coordinate|undefined} */
                    var tooltipCoord = evt.coordinate;

                    listener = sketch.getGeometry().on('change', function(evt) {
                        var geom = evt.target;

                        var output;
                        if (geom instanceof ol.geom.Polygon) {

                            output = formatArea(geom);
                            tooltipCoord = geom.getInteriorPoint().getCoordinates();

                        } else if (geom instanceof ol.geom.LineString) {

                            output = formatLength(geom);
                            tooltipCoord = geom.getLastCoordinate();
                        }
                        measureTooltipElement.innerHTML = output;
                        measureTooltip.setPosition(tooltipCoord);
                    });
                }, this);

            draw.on('drawend',
                function() {
                    measureTooltipElement.className = 'tooltip tooltip-static';
                    measureTooltip.setOffset([0, -7]);
                    // unset bản phác thảo
                    sketch = null;
                    // unset chú giải công cụ để có thể tạo một chú giải mới
                    measureTooltipElement = null;
                    createMeasureTooltip();
                    ol.Observable.unByKey(listener);
                }, this);
        }
    }

    /**
     * Tạo chú giải công cụ trợ giúp mới
     */
    function createHelpTooltip() {
        if (helpTooltipElement) {
            helpTooltipElement.parentNode.removeChild(helpTooltipElement);
        }
        helpTooltipElement = document.createElement('div');
        helpTooltipElement.className = 'tooltip hidden';
        helpTooltip = new ol.Overlay({
            element: helpTooltipElement,
            offset: [15, 0],
            positioning: 'center-left'
        });
        map.addOverlay(helpTooltip);
    }

    /**
     * Tạo chú giải công cụ đo lường mới
     */
    function createMeasureTooltip() {
        if (measureTooltipElement) {
            measureTooltipElement.parentNode.removeChild(measureTooltipElement);
        }
        measureTooltipElement = document.createElement('div');
        measureTooltipElement.className = 'tooltip tooltip-measure';

        measureTooltip = new ol.Overlay({
            element: measureTooltipElement,
            offset: [0, -15],
            positioning: 'bottom-center'
        });
        map.addOverlay(measureTooltip);
    }

    /**
     * Cho phép người dùng thay đổi kiểu hình học.
     */
    measuretype.onchange = function() {
        map.un('singleclick', getinfo_nhatro);
        map.un('singleclick', getinfo_tienich);
        map.un('singleclick', getinfo_trambus);
        overlay.setPosition(undefined);
        closer.blur();
        map.removeInteraction(draw);
        addInteraction();
    };
    // End Measure(đo lường) tool

    // Bật tắt layers
    $("#chkThanhPho").change(function() {
        if ($("#chkThanhPho").is(":checked")) {
            ThanhPho.setVisible(true);
        } else {
            ThanhPho.setVisible(false);
        }
    });

    $("#chkXaPhuong").change(function() {
        if ($("#chkXaPhuong").is(":checked")) {
            XaPhuong.setVisible(true);
        } else {
            XaPhuong.setVisible(false);
        }
    });

    $("#chkDuong").change(function() {
        if ($("#chkDuong").is(":checked")) {
            Duong.setVisible(true);
        } else {
            Duong.setVisible(false);
        }
    });

    $("#chkBus").change(function() {
        if ($("#chkBus").is(":checked")) {
            TramBus.setVisible(true);
        } else {
            TramBus.setVisible(false);
        }
    });

    $("#chkTienIch").change(function() {
        if ($("#chkTienIch").is(":checked")) {
            TienIch.setVisible(true);
        } else {
            TienIch.setVisible(false);
        }
    });

    $("#chkTruong").change(function() {
        if ($("#chkTruong").is(":checked")) {
            Truong.setVisible(true);
        } else {
            Truong.setVisible(false);
        }
    });

    $("#chkNhaTro").change(function() {
        if ($("#chkNhaTro").is(":checked")) {
            NhaTro.setVisible(true);
        } else {
            NhaTro.setVisible(false);
        }
    });
    // End Bật tắt layers
});