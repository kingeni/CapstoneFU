var CONSTANT = require('../broker/Constant.js');
var test = getCoordinates(3, 2, 1);

function getCoordinates(radiusA, radiusB, radiusC) {
    var linearEquaArr = [];
    var pointArrCr1 = [];
    var pointArrCr2 = [];
    var midPoint = [];
    var equaMidPoint = [];
    var result = [];

    //create linear equation  goes throught two point center
    linearEquaArr[0] = createEquationsVia2Point(CONSTANT.A, CONSTANT.B);
    linearEquaArr[1] = createEquationsVia2Point(CONSTANT.A, CONSTANT.C);

    // get intersection of circles and lines
    pointArrCr1[0] = getPoint(CONSTANT.A, linearEquaArr[0], radiusA);
    pointArrCr1[1] = getPoint(CONSTANT.B, linearEquaArr[0], radiusB);
    pointArrCr2[0] = getPoint(CONSTANT.A, linearEquaArr[1], radiusA);
    pointArrCr2[1] = getPoint(CONSTANT.C, linearEquaArr[1], radiusC);
   

    // get mid point 
    midPoint[0] = getMidPoint(pointArrCr1[0], pointArrCr1[1]);
    midPoint[1] = getMidPoint(pointArrCr2[0], pointArrCr2[1]);
  

    // create equation linear goes throught midPoint and perpendicular
    equaMidPoint[0] = getEquationThroughMidPoint(linearEquaArr[0], midPoint[0]);
    equaMidPoint[1] = getEquationThroughMidPoint(linearEquaArr[1], midPoint[1]);
  
    // find coordinates of objects
    result = gauss(equaMidPoint);
    return result;
}

function getEquationThroughMidPoint(equation, midPoint) {
    // a.a' = -1 
    var a = -1 / equation[1];
    // b = y(midpoint) -a' * x(midPoint)
    var b = midPoint[1] - a * midPoint[0];
    // New Equation throught midPoint
    var arry = [];
    // y = ax + b => -ax + y = b
    arry[0] = (-1) * a;
    arry[1] = 1;
    arry[2] = b;
    return [...arry];
}

function getMidPoint(pointListA, pointListB) {
    var max = 0;
    var pointMid = [];
    var maxPosi = [];
    var sumX = 0;
    var sumY = 0;

    //save position of max length
    for (var i = 0; i < 2; i++) {
        sumX += (pointListA[i][0] + pointListB[i][0]) ;
        sumY += (pointListA[i][1] + pointListB[i][1]);
        for (var j = 0; j < 2; j++) {
            var distance = getDistanceFromTwoPoint(pointListA[i], pointListB[j]);
           
            if (distance > max) {
                max = distance;
             
                maxPosi[0] = pointListA[i][0] + pointListB[j][0];
                maxPosi[1] = pointListA[i][1] + pointListB[j][1];
            
            }
        }
    }

    pointMid[0] = Math.round(((sumX - maxPosi[0]) / 2) * 100) / 100;
    pointMid[1] = Math.round(((sumY - maxPosi[1]) / 2) * 100) / 100;

    return pointMid;
}

function getPoint(A, equation, radius) {
    var pointList = [];

    // a, b, c of quaraticEquation
    var a = (1 + Math.pow(equation[1], 2));
    var b = ((-2) * A[0]) + (2 * equation[1] * (equation[2] - A[1]));
    var c = Math.pow((equation[2] - A[1]), 2) - Math.pow(radius, 2);

    var result = solveQuadraticEquation2(a, b, c);

    for (var i = 0; i < 2; i++) {
        var point = [];
        for (var j = 0; j < 2; j++) {
            if (j === 0) {
                point[j] = result[i];
                continue;
            }
            point[j] = Math.round((result[i] * equation[1] + equation[2]) * 100) / 100;
        }
        pointList.push(point);
    }
    return pointList;
}

function solveQuadraticEquation2(a, b, c) {
    var result = new Array(2);
    result[0] = (-1 * b + Math.sqrt(Math.pow(b, 2) - (4 * a * c))) / (2 * a);
    result[0] = Math.round(result[0] * 100) / 100;
    result[1] = (-1 * b - Math.sqrt(Math.pow(b, 2) - (4 * a * c))) / (2 * a);
    result[1] = Math.round(result[1] * 100) / 100;
    return result;
}

function getDistanceFromTwoPoint(A, B) {
    var distanceAB = 0;
    for (var i = 0; i < 2; i++) {
        distanceAB += Math.pow((A[i] - B[i]), 2);
    }
    return Math.round(Math.sqrt(distanceAB) * 100) / 100;
}

/*
    linear equations y= ax + b 
*/
function createEquationsVia2Point(A, B) {
    var _A = A.slice(0);
    var _B = B.slice(0);

    var a = [];
    var equa = [];

    // y = ax + b  find a , b => ax + b = y
    _A[2] = _A[1];
    _B[2] = _B[1];
    _B[1] = _A[1] = 1;
    a.push(_A);
    a.push(_B);

    var result = gauss(a);
    // y = ax + b
    equa[0] = 1;
    equa[2] = result[1];
    equa[1] = result[0];
    var b = equa.map(digit => Math.round(digit * 100) / 100);

    return [...b];
}
/* 
   distanceA : pow(distanceA, 2)
   distanceB : pow(distanceB , 2)
*/
function createNewEquations(distanceA, A, distanceB, B) {
    var a = [];
    var sumA = 0;
    var sumB = 0;

    //create element in matrix
    for (let i = 0; i < 2; i++) {
        a.push(2 * (-A[i] + B[i]));
        sumA += Math.pow(A[i], 2);
        sumB += Math.pow(B[i], 2);
    }
    // last element in matrix
    a[2] = distanceA - distanceB - sumA + sumB;
    return [...a];
}

function gauss(A) {
    var n = A.length;

    for (var i = 0; i < n; i++) {
        // Search for maximum in this column
        var maxEl = Math.abs(A[i][i]);
        var maxRow = i;
        for (var k = i + 1; k < n; k++) {
            if (Math.abs(A[k][i]) > maxEl) {
                maxEl = Math.abs(A[k][i]);
                maxRow = k;
            }
        }

        // Swap maximum row with current row (column by column)
        for (var k = i; k < n + 1; k++) {
            var tmp = A[maxRow][k];
            A[maxRow][k] = A[i][k];
            A[i][k] = tmp;
        }

        // Make all rows below this one 0 in current column
        for (k = i + 1; k < n; k++) {
            var c = -A[k][i] / A[i][i];
            for (var j = i; j < n + 1; j++) {
                if (i == j) {
                    A[k][j] = 0;
                } else {
                    A[k][j] += c * A[i][j];
                }
            }
        }
    }

    // Solve equation Ax=b for an upper triangular matrix A
    var x = new Array(n);
    for (var i = n - 1; i > -1; i--) {
        x[i] = A[i][n] / A[i][i];
        for (var k = i - 1; k > -1; k--) {
            A[k][n] -= A[k][i] * x[i];
        }
    }
    // Round to two number 
    x.forEach(digit => Math.round(digit * 100) / 100);
    return x;
}

function contHexToString(A) {

    // cut space in string
    let newText = A.split(' ').filter(word => word !== "");

    //convert string to 16 then convert to ASCII
    let _newText = newText.map(x => String.fromCharCode(parseInt(x, 16)));
    let result = "";

    //convert Array to string
    _newText.forEach(x => result += x);

    return [...result];
}

module.exports = {
    contHexToString: contHexToString,
    getCoordinates: getCoordinates
};

