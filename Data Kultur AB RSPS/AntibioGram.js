function onEdit(e)
{
  if(e.source.getSheetName() == "Pengaturan" && e.range.getRow() > 4 &&
      (  
        e.range.getColumn() == 4 ||
        e.range.getColumn() == 5 ||
        e.range.getColumn() == 7 ||
        e.range.getColumn() == 8 ||
        e.range.getColumn() == 9 ||
        (e.range.getColumn() % 4 == 0)
      )
    )
  {
    ViewSettingChangeCheck(e);
  }
}
function ViewSettingChangeCheck(e)
{
  DataCulSetting = e.source.getSheetByName("Pengaturan");
  SettingVariableValues = DataCulSetting.getRange(3,2,12).getValues();
  DatabaseName = SettingVariableValues[0];
  ViewName = SettingVariableValues[1];
  
  DataCulMaster = e.source.getSheetByName(DatabaseName);
  if( DataCulMaster)
  {
    DataCulView = e.source.getSheetByName(ViewName);
    if(DataCulView == null)
    {
      DataCulView = e.source.insertSheet(ViewName);
    }
    ViewSettingChange(DataCulMaster,DataCulSetting, DataCulView, SettingVariableValues);
  }
  
}
function ViewSettingChange(DataCulMaster,DataCulSetting, DataCulView, SettingVariableValues)
{
  let maxBakteri = SettingVariableValues[7];
  let bakteriColumn = SettingVariableValues[6];
  let bakteriStart = SettingVariableValues[8];
  let maxObat = SettingVariableValues[10];
  let obatColumn = SettingVariableValues[9];
  let obatStart = SettingVariableValues[11];
  
  let Row = 5;
  let Column = letterToColumn(SettingVariableValues[3].toString());
  let NumRows = 9;
  let NumColumn = 6;

  let sortingValues = DataCulSetting.getRange(Row, Column, NumRows, NumColumn).getValues();

  Row = 5;
  Column = letterToColumn(SettingVariableValues[4].toString());
  NumRows = 6;
  NumColumn = 3;

  let sampleValues = DataCulSetting.getRange(Row, Column, NumRows, NumColumn).getValues();
  let sampleCount = DataCulSetting.getRange(Row-2, Column+1).getValue();

  Row = 5;
  Column = letterToColumn(SettingVariableValues[5].toString());
  NumRows = 3;
  NumColumn = 3;

  let toleranceValues = DataCulSetting.getRange(Row, Column, NumRows, NumColumn).getValues();
  let toleranceCount = DataCulSetting.getRange(Row-2, Column+1).getValue()

  let WriteBerdasarkan = sortingValues[2][3];
  if(sampleCount > 0 && toleranceCount > 0 && maxBakteri > 0 && maxObat > 0){
    DataCulView.clear();
    if(WriteBerdasarkan == "Bakteri")
    {
      ViewWriteBacteria(DataCulSetting, DataCulView, sortingValues, sampleValues, sampleCount, toleranceValues, toleranceCount, 1 ,1 , maxBakteri, maxObat, bakteriColumn, obatColumn, bakteriStart, obatStart);
    }else{
      ViewWriteObat(DataCulSetting, DataCulView, sortingValues, sampleValues, sampleCount, toleranceValues, toleranceCount , 1 ,1 , maxObat , maxBakteri, obatColumn, bakteriColumn, bakteriStart, obatStart);
    }
    DataCulView.autoResizeColumn(2);
    DataCulView.setFrozenColumns(3);
    DataCulView.setFrozenRows(3);
  }
}

function ViewWriteBacteria(DataCulSetting, DataCulView, sortingValues, sampleValues, sampleCount, toleranceValues, toleranceCount, row, column, maxRow, maxColumn, numRow, numColumn, startRow, startColumn)
{
  let k = 0;
  let ViewArray = new Array();
  for(let i = 0; i < maxRow+5;i++)
  {
    ViewArray[i] = new Array();
    for(let j = 0; j < toleranceCount * 2 * maxColumn+5; j++)
    {
      ViewArray[i][j]=null;
    }
  }
  for(let i = 0, l = 0; i < maxRow;)
  {
    if(DataCulSetting.getRange(i+l+19,4).getValue())
    {
      ViewArray[i+4][1] = DataCulSetting.getRange(i+l+19,5).getValue();
      if(values[2][3])
      {
        if(values[2][5] == "Termasuk")
        {
          ViewArray[i+4][2] = "=COUNTIFS('Data Master'!$J$3:$J,$B"+ (i+5) +",'Data Master'!$H$3:$H,$A$3"+ ViewSortAdd(values);
        }else{
          ViewArray[i+4][2] ="=COUNTIFS('Data Master'!$J$3:$J,$B"+ (i+5) +",'Data Master'!$H$3:$H,$A$3) - COUNTIFS('Data Master'!$J$3:$J,$B"+ (i+5) +",'Data Master'!$H$3:$H,$A$3" +ViewSortAdd(values);  
        }
      }else{
        ViewArray[i+4][2] = "=COUNTIFS('Data Master'!$J$3:$J,$B"+ (i+5) +",'Data Master'!$H$3:$H,$A$3)";
      }
      i++;
    }else{
      l++;
    }
  }
  for(let i = 0, l = 0; i < maxColumn;)
  {
    k = 3;
    if(DataCulSetting.getRange(i+ l +52,4).getValue()){
      if(values[15][3]){
        ViewArray[1][i*tolerance+k] = DataCulSetting.getRange(i+ l +52,5).getValue();
        ViewArray[1][i*tolerance+k+1] = DataCulSetting.getRange(i+ l +52,5).getValue();
        ViewArray[2][i*tolerance+k] = "%Sensitive";
        ViewArray[2][i*tolerance+k+1] = "Total";
        k+=2;
      }
      if(values[16][3]){
        ViewArray[1][i*tolerance+k] = DataCulSetting.getRange(i+ l +52,5).getValue();
        ViewArray[1][i*tolerance+k+1] = DataCulSetting.getRange(i+ l +52,5).getValue();
        ViewArray[2][i*tolerance+k] = "%Intermediate";
        ViewArray[2][i*tolerance+k+1] = "Total";
        k+=2;
      }
      if(values[17][3]){
        ViewArray[1][i*tolerance+k] = DataCulSetting.getRange(i+ l +52,5).getValue();
        ViewArray[1][i*tolerance+k+1] = DataCulSetting.getRange(i+ l +52,5).getValue();
        ViewArray[2][i*tolerance+k] = "%Resistensi";
        ViewArray[2][i*tolerance+k+1] = "Total";
        k+=2;
      }
      i++;
    }else{
      l++;
    }
  }
  for(let i = 0; i < maxRow; i++)
  {
    for(let j = 0; j < maxColumn; j++)
    {
      k = 3; 
      if(values[15][3]){
        ViewArray[i+4][j*tolerance+k] = "="+columnToLetter(j*tolerance+2+k)+(i+5)+"/$"+columnToLetter(3)+(i+5)+"*100";
        ViewArray[i+4][j*tolerance+k+1] = "=COUNTIFS('Data Master'!$J$3:$J,$B"+ (i+5) +",'Data Master'!$H$3:$H,$A$3,'Data Master'!$"+columnToLetter(j+12)+"$"+3 + ":$" + columnToLetter(j+12)+",\"S\""+ ViewSortAdd(values);
        k+=2;
      }
      if(values[16][3]){
        ViewArray[i+4][j*tolerance+k] = "="+columnToLetter(j*tolerance+2+k)+(i+5)+"/$"+columnToLetter(3)+(i+5)+"*100";
        ViewArray[i+4][j*tolerance+k+1] = "=COUNTIFS('Data Master'!$J$3:$J,$B"+ (i+5) +",'Data Master'!$H$3:$H,$A$3,'Data Master'!$"+columnToLetter(j+12)+"$"+3 + ":$" + columnToLetter(j+12)+",\"I\""+ ViewSortAdd(values);
        k+=2;
      }
      if(values[17][3]){
        ViewArray[i+4][j*tolerance+k] = "="+columnToLetter(j*tolerance+2+k)+(i+5)+"/$"+columnToLetter(3)+(i+5)+"*100";
        ViewArray[i+4][j*tolerance+k+1] = "=COUNTIFS('Data Master'!$J$3:$J,$B"+ (i+5) +",'Data Master'!$H$3:$H,$A$3,'Data Master'!$"+columnToLetter(j+12)+"$"+3 + ":$" + columnToLetter(j+12)+",\"R\""+ ViewSortAdd(values);
        k+=2;
      }
    }
  }
  ViewArray[0][2] = "Jumlah Isolat";
  ViewArray[3][0] = "=COUNTIF('Data Master'!$H$3:$H,$A$3)";
  DataCulView.getRange(row,column,maxRow+5,tolerance * maxColumn+5).setValues(ViewArray);


}
function ViewWriteObat(DataCulSetting, DataCulView, sortingValues, sampleValues, sampleCount, toleranceValues, toleranceCount, row, column, maxRow, maxColumn, numRow, numColumn, startRow, startColumn)
{
  let tolerance = values[3][10] * 2;
  let k = 0;
  let ViewArray = new Array();
  for(let i = 0; i < tolerance *maxRow+5;i++)
  {
    ViewArray[i] = new Array();
    for(let j = 0; j <  MaxColumn+5; j++)
    {
      ViewArray[i][j]=null;
    }
  }
  for(let i = 0, l = 0; i < maxRow;)
  {
    k = 4;
    if(DataCulSetting.getRange(i+ l +52,4).getValue()){
        ViewArray[i*tolerance+k][1] = DataCulSetting.getRange(i+ l +52,5).getValue();
      if(values[15][3]){
        ViewArray[i*tolerance+k][2] = "%Sensitive";
        ViewArray[i*tolerance+k+1][2] = "Total";
        k+=2;
      }
      if(values[16][3]){
        ViewArray[i*tolerance+k][2] = "%Intermediate";
        ViewArray[i*tolerance+k+1][2] = "Total";
        k+=2;
      }
      if(values[17][3]){
        ViewArray[i*tolerance+k][2] = "%Resistensi";
        ViewArray[i*tolerance+k+1][2] = "Total";
        k+=2;
      }
      i++;
    }else{
      l++;
    }
  }
  for(let i = 0, l = 0; i < MaxColumn;)
  {
    if(DataCulSetting.getRange(i+l+19,4).getValue())
    {
      ViewArray[1][i+4] = DataCulSetting.getRange(i+l+19,5).getValue();
      if(values[2][3])
      {
        if(values[2][5] == "Termasuk")
        {
          ViewArray[2][i+4] = "=COUNTIFS('Data Master'!$J$3:$J,"+columnToLetter(i+5)  +"$2,'Data Master'!$H$3:$H,$A$3"+ ViewSortAdd(values);
        }else{
          ViewArray[2][i+4] ="=COUNTIFS('Data Master'!$J$3:$J,"+columnToLetter(i+5)  +"$2,'Data Master'!$H$3:$H,$A$3) - COUNTIFS('Data Master'!$J$3:$J,"+columnToLetter(i+5)  +"$2,'Data Master'!$H$3:$H,$A$3" +ViewSortAdd(values);  
        }
      }else{
        ViewArray[2][i+4] = "=COUNTIFS('Data Master'!$J$3:$J,"+columnToLetter(i+5)  +"$2,'Data Master'!$H$3:$H,$A$3)";
      }
      i++;
    }else{
      l++;
    }
  }
  for(let i = 0; i < maxRow; i++)
  {
    for(let j = 0; j < MaxColumn; j++)
    {
      k = 4; 
      if(values[15][3]){
        ViewArray[i*tolerance+k][j+4] = "="+columnToLetter(j+5)+(i*tolerance+2+k)+"/$"+columnToLetter(j+5)+(3)+"*100";
        ViewArray[i*tolerance+k+1][j+4] = "=COUNTIFS('Data Master'!$J$3:$J,"+ columnToLetter(j+5) +"$2,'Data Master'!$H$3:$H,$A$3,'Data Master'!$"+columnToLetter(i+12)+"$"+3 + ":$" + columnToLetter(i+10)+",\"S\""+ ViewSortAdd(values);
        k+=2;
      }
      if(values[16][3]){
        ViewArray[i*tolerance+k][j+4] = "="+columnToLetter(j+5)+(i*tolerance+2+k)+"/$"+columnToLetter(j+5)+(3)+"*100";
        ViewArray[i*tolerance+k+1][j+4] = "=COUNTIFS('Data Master'!$J$3:$J,"+ columnToLetter(j+5) +"$2,'Data Master'!$H$3:$H,$A$3,'Data Master'!$"+columnToLetter(i+12)+"$"+3 + ":$" + columnToLetter(i+10)+",\"I\""+ ViewSortAdd(values);
        k+=2;
      }
      if(values[17][3]){
        ViewArray[i*tolerance+k][j+4] = "="+columnToLetter(j+5)+(i*tolerance+2+k)+"/$"+columnToLetter(j+5)+(3)+"*100";
        ViewArray[i*tolerance+k+1][j+4] = "=COUNTIFS('Data Master'!$J$3:$J,"+ columnToLetter(j+5) +"$2,'Data Master'!$H$3:$H,$A$3,'Data Master'!$"+columnToLetter(i+12)+"$"+3 + ":$" + columnToLetter(i+10)+",\"R\""+ ViewSortAdd(values);
        k+=2;
      }
    }
  }
  DataCulView.getRange(row,column,tolerance * maxRow+5, MaxColumn+5).setValues(ViewArray);
}
function ViewSortAdd(values)
{
  let StringAdd = "";
  let leftCompareSign = "";
  let rightCompareSign = "";
  if(values[4][3])
  {
    if(values[4][5] == "Luar")
    {
      leftCompareSign = "<";
      rightCompareSign = ">";
    }else{
      leftCompareSign = ">";
      rightCompareSign = "<";
    }
    StringAdd = StringAdd + ",'Data Master'!$F$3:$F,\"" + leftCompareSign +"\" & 'View Setting'!$G$5"+ ",'Data Master'!$F$3:$F,\"" + rightCompareSign +"\" & 'View Setting'!$H$5";
  }
  if(values[5][3])
  {
    StringAdd = StringAdd + ",'Data Master'!$D$3:$D,\"" +values[5][5]+"\"";
  }
  if(values[6][3])
  {
    if(values[6][5] == "Luar")
    {
      leftCompareSign = "<";
      rightCompareSign = ">";
    }else{
      leftCompareSign = ">";
      rightCompareSign = "<";
    }
    StringAdd = StringAdd + ",'Data Master'!$C$3:$C,\"" + leftCompareSign +"\" & 'View Setting'!$G$7"+ ",'Data Master'!$C$3:$C,\"" + rightCompareSign +"\" & 'View Setting'!$H$7";
  }
  if(values[7][3])
  {
    StringAdd = StringAdd + ",'Data Master'!$I$3:$I,\"" +values[7][5]+"\"";
  }
  StringAdd = StringAdd + ")";
  return StringAdd;
}
function databasePath(DatabaseName, letter)
{
  return "'"+DatabaseName+"'!$"+letter+"$3:$"+letter;
}
function columnToLetter(column)
{
  var temp, letter = '';
  while (column > 0)
  {
    temp = (column - 1) % 26;
    letter = String.fromCharCode(temp + 65) + letter;
    column = (column - temp - 1) / 26;
  }
  return letter;
}

function letterToColumn(letter)
{
  var column = 0, length = letter.length;
  for (var i = 0; i < length; i++)
  {
    column += (letter.charCodeAt(i) - 64) * Math.pow(26, length - i - 1);
  }
  return column;
}