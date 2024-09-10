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
  SettingVariableValues = DataCulSetting.getRange(3,2,14).getValues();
  DatabaseName = SettingVariableValues[0].toString();
  ViewName = SettingVariableValues[1].toString();
  
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
  let bakteriStart = letterToColumn(SettingVariableValues[8].toString());
  let maxObat = SettingVariableValues[10];
  let obatColumn = SettingVariableValues[9];
  let obatStart = letterToColumn(SettingVariableValues[11].toString());
  let databaseObatStart = letterToColumn(SettingVariableValues[13].toString())
  
  let Row = 5;
  let Column = letterToColumn(SettingVariableValues[3].toString());
  let NumRows = 10;
  let NumColumn = 6;

  let sortingValues = DataCulSetting.getRange(Row, Column, NumRows, NumColumn).getValues();

  Column = letterToColumn(SettingVariableValues[4].toString());
  NumRows = 6;
  NumColumn = 3;

  let sampleValues = DataCulSetting.getRange(Row, Column, NumRows, NumColumn).getValues();
  let sampleCount = DataCulSetting.getRange(Row-2, Column+1).getValue();

  Column = letterToColumn(SettingVariableValues[5].toString());
  NumRows = 3;
  NumColumn = 2;

  let toleranceValues = DataCulSetting.getRange(Row, Column, NumRows, NumColumn).getValues();
  let toleranceCount = DataCulSetting.getRange(Row-2, Column).getValue()

  let WriteBerdasarkan = sortingValues[2][3];

  if(sampleCount > 0 && toleranceCount > 0 && maxBakteri > 0 && maxObat > 0){
    DataCulView.clear();
    if(WriteBerdasarkan == "Bakteri")
    {
      ViewWriteBacteria(DataCulMaster, DataCulSetting, DataCulView, sortingValues, sampleValues, sampleCount, toleranceValues, toleranceCount * 2, 1 ,1 , maxBakteri, maxObat, bakteriColumn, obatColumn, bakteriStart, obatStart,databaseObatStart);
    }else{
      ViewWriteObat(DataCulMaster, DataCulSetting, DataCulView, sortingValues, sampleValues, sampleCount, toleranceValues, toleranceCount * 2 , 1 ,1 , maxObat , maxBakteri, obatColumn, bakteriColumn,obatStart ,bakteriStart, databaseObatStart);
    }
    DataCulView.autoResizeColumn(2);
    DataCulView.setFrozenColumns(3);
    DataCulView.setFrozenRows(3);
  }
}

function ViewWriteBacteria(DataCulMaster, DataCulSetting, DataCulView, sortingValues, sampleValues, sampleCount, toleranceValues, toleranceCount, row, column, maxRow, maxColumn, numRow, numColumn, startRow, startColumn, databaseObatStart)
{
  let k = 0;
  let DatabaseName = DataCulMaster.getName();
  let DatabaseLetter = "";
  let sampleName = samplePath(sampleValues, sampleCount);
  let viewSorted = "";
  if (sortingValues[0][1])
  {
    viewSorted = ViewSortAdd(sortingValues, DataCulMaster, DataCulSetting);
  }
  let ViewArray = new Array();
  for(let i = 0; i < maxRow+5;i++)
  {
    ViewArray[i] = new Array();
    for(let j = 0; j < toleranceCount  * maxColumn+5; j++)
    {
      ViewArray[i][j]=null;
    }
  }
  
  k = 0;
  for(let i = 0, index = startRow; i < maxRow;)
  {
    let numCount = DataCulSetting.getRange(3,index).getValue();
    let rowArray = DataCulSetting.getRange(5,index, maxRow, 3).getValues();
    if(i>0)
    {
      k++;
    }
    for(let j = 0, l = 0; j < numCount;l++)
    {
      
      if(rowArray[l][0])
      {
        j++;
        ViewArray[i+k+4][1] = rowArray[l][1]; 
        if(sortingValues[0][1])
        {
          if(sortingValues[0][3] == "Termasuk")
          {
            ViewArray[i+k+4][2] = "=COUNTIFS("+ databasePath(DatabaseName,sortingValues[0][0]) +",$B"+ (i+k+5) +","+ databasePath(DatabaseName,sampleValues[0][0]) +","+ sampleName + viewSorted;
          }else{
            ViewArray[i+k+4][2] = "=COUNTIFS("+ databasePath(DatabaseName,sortingValues[0][0]) +",$B"+ (i+k+5) +","+ databasePath(DatabaseName,sampleValues[0][0]) +","+ sampleName +") - COUNTIFS("+ databasePath(DatabaseName,sortingValues[0][0]) +",$B"+ (i+k+5) +","+ databasePath(DatabaseName,sampleValues[0][0]) +","+ sampleName +  viewSorted;
          }
        }else{
          ViewArray[i+k+4][2] = "=COUNTIFS("+ databasePath(DatabaseName,sortingValues[0][0]) +",$B"+ (i+k+5) +","+ databasePath(DatabaseName,sampleValues[0][0]) +","+ sampleName +")";
        }
        i++
      }
    }
    index += 4;
  }


  let numCount = DataCulSetting.getRange(3,startColumn+1).getValue();
  let columnArray = DataCulSetting.getRange(5,startColumn, maxColumn, 3).getValues();
  for(let i = 0, l = 0; i < numCount;l++)
  {
    k = 3;
    if(columnArray[l][1])
    {
      if(toleranceValues[0][0]){
        ViewArray[1][i*toleranceCount+k] = columnArray[l][2];
        ViewArray[1][i*toleranceCount+k+1] = columnArray[l][2];
        ViewArray[2][i*toleranceCount+k] = "%Sensitive";
        ViewArray[2][i*toleranceCount+k+1] = "Total";
        k+=2;
      }
      if(toleranceValues[1][0]){
        ViewArray[1][i*toleranceCount+k] = columnArray[l][2];
        ViewArray[1][i*toleranceCount+k+1] = columnArray[l][2];
        ViewArray[2][i*toleranceCount+k] = "%Intermediate";
        ViewArray[2][i*toleranceCount+k+1] = "Total";
        k+=2;
      }
      if(toleranceValues[2][0]){
        ViewArray[1][i*toleranceCount+k] = columnArray[l][2];
        ViewArray[1][i*toleranceCount+k+1] = columnArray[l][2];
        ViewArray[2][i*toleranceCount+k] = "%Resistensi";
        ViewArray[2][i*toleranceCount+k+1] = "Total";
        k+=2;
      }
      i++;
      
    }
  }
  numCount = DataCulSetting.getRange(3,startRow).getValue();
  for(let i = 0,m = 0, n = 0; i < maxRow; i++, m++)
  {
    if(m >= numCount)
    {
      n++;
      numCount = DataCulSetting.getRange(3,startRow + (4*n)).getValue();
      m = 0;
    }
    for(let j = 0 , l = 0; j < maxColumn; l++)
    {
      k = 3; 
      if(columnArray[l][1])
      {
        if(toleranceValues[0][0]){
          ViewArray[i+4+n][j*toleranceCount+k] = "="+columnToLetter(j*toleranceCount+2+k)+(i+5)+"/$"+columnToLetter(3)+(i+5)+"*100";
          ViewArray[i+4+n][j*toleranceCount+k+1] = "=COUNTIFS("+ databasePath(DatabaseName,sortingValues[0][0]) +",$B"+ (i+5) +","+ databasePath(DatabaseName,sampleValues[0][0]) +","+ sampleName+",'"+DatabaseName+"'!$"+columnToLetter(l+databaseObatStart)+"$"+3 + ":$" + columnToLetter(l+databaseObatStart)+",\"S\""+ viewSorted;
          k+=2;
        }
        if(toleranceValues[1][0]){
          ViewArray[i+4+n][j*toleranceCount+k] = "="+columnToLetter(l*toleranceCount+2+k)+(i+5)+"/$"+columnToLetter(3)+(i+5)+"*100";
          ViewArray[i+4+n][j*toleranceCount+k+1] = "=COUNTIFS("+ databasePath(DatabaseName,sortingValues[0][0]) +",$B"+ (i+5) +","+ databasePath(DatabaseName,sampleValues[0][0]) +","+ sampleName+",'"+DatabaseName+"'!$"+columnToLetter(l+databaseObatStart)+"$"+3 + ":$" + columnToLetter(l+databaseObatStart)+",\"I\""+ viewSorted;
          k+=2;
        }
        if(toleranceValues[2][0]){
          ViewArray[i+4+n][j*toleranceCount+k] = "="+columnToLetter(j*toleranceCount+2+k)+(i+5)+"/$"+columnToLetter(3)+(i+5)+"*100";
          ViewArray[i+4+n][j*toleranceCount+k+1] = "=COUNTIFS("+ databasePath(DatabaseName,sortingValues[0][0]) +",$B"+ (i+5) +","+ databasePath(DatabaseName,sampleValues[0][0]) +","+ sampleName+",'"+DatabaseName+"'!$"+columnToLetter(l+databaseObatStart)+"$"+3 + ":$" + columnToLetter(l+databaseObatStart)+",\"R\""+ viewSorted;
          k+=2;
        }
        j++;
      }
    }
  }
  ViewArray[0][2] = "Jumlah Isolat";
  ViewArray[2][1] = "Total";
  ViewArray[2][2] = "=COUNTIF('Data Master'!$H$3:$H,"+ sampleName+ ")";
  DataCulView.getRange(row,column,maxRow+5,toleranceCount  * maxColumn+5).setValues(ViewArray);


}

function ViewWriteObat(DataCulSetting, DataCulView, sortingValues, sampleValues, sampleCount, toleranceValues, toleranceCount, row, column, maxRow, maxColumn, numRow, numColumn, startRow, startColumn, databaseObatStart)
{
  let k = 0;
  let ViewArray = new Array();
  for(let i = 0; i < toleranceCount *maxRow+5;i++)
  {
    ViewArray[i] = new Array();
    for(let j = 0; j <  MaxColumn+5; j++)
    {
      ViewArray[i][j]=null;
    }
  }
  let numCount = DataCulSetting.getRange(3,startRow+1).getValue();
  let rowArray = DataCulSetting.getRange(5,startRow, maxRow, 3).getValues();
  for(let i = 0, l = 0; i < numCount;l++)
  {
    k = 4;
    if(rowArray[l][1])
    {
      ViewArray[i*toleranceCount+k][1] = rowArray[l][2];
      if(toleranceValues[0][0]){
        ViewArray[2][i*toleranceCount+k] = "%Sensitive";
        ViewArray[2][i*toleranceCount+k+1] = "Total";
        k+=2;
      }
      if(toleranceValues[1][0]){
        ViewArray[2][i*toleranceCount+k] = "%Intermediate";
        ViewArray[2][i*toleranceCount+k+1] = "Total";
        k+=2;
      }
      if(toleranceValues[2][0]){
        ViewArray[2][i*toleranceCount+k] = "%Resistensi";
        ViewArray[2][i*toleranceCount+k+1] = "Total";
        k+=2;
      }
      i++;
      
    }
  }
    k = 0;
  for(let i = 0, index = startColumn; i < maxColumn;)
  {
    numCount = DataCulSetting.getRange(3,index).getValue();
    let columnArray = DataCulSetting.getRange(5,index, maxColumn, 3).getValues();
    if(i>0)
    {
      k++;
    }
    for(let j = 0, l = 0; j < numCount;l++)
    {
      if(columnArray[l][0])
      {
        j++;
        ViewArray[1][i+k+4] = columnArray[l][1]; 
        if(sortingValues[0][1])
        {
          if(sortingValues[0][3] == "Termasuk")
          {
            ViewArray[2][i+k+4] = "=COUNTIFS("+ databasePath(DatabaseName,sortingValues[0][0]) +","+columnToLetter(i+k+5)  +"$2,"+ databasePath(DatabaseName,sampleValues[0][0]) +","+ sampleName + viewSorted;
          }else{
            ViewArray[2][i+k+4] = "=COUNTIFS("+ databasePath(DatabaseName,sortingValues[0][0]) +","+columnToLetter(i+k+5)  +"$2,"+ databasePath(DatabaseName,sampleValues[0][0]) +","+ sampleName +") - COUNTIFS("+ databasePath(DatabaseName,sortingValues[0][0]) +",$B"+ (i+k+5) +","+ databasePath(DatabaseName,sampleValues[0][0]) +","+ sampleName +  viewSorted;
          }
        }else{
          ViewArray[2][i+k+4] = "=COUNTIFS("+ databasePath(DatabaseName,sortingValues[0][0]) +","+columnToLetter(i+k+5)  +"$2,"+ databasePath(DatabaseName,sampleValues[0][0]) +","+ sampleName +")";
        }
        i++
      }
    }
    index += 4;
  }
  // for(let i = 0; i < maxRow; i++)
  // {
  //   for(let j = 0; j < MaxColumn; j++)
  //   {
  //     k = 4; 
  //     if(values[15][3]){
  //       ViewArray[i*tolerance+k][j+4] = "="+columnToLetter(j+5)+(i*tolerance+2+k)+"/$"+columnToLetter(j+5)+(3)+"*100";
  //       ViewArray[i*tolerance+k+1][j+4] = "=COUNTIFS('Data Master'!$J$3:$J,"+ columnToLetter(j+5) +"$2,'Data Master'!$H$3:$H,$A$3,'Data Master'!$"+columnToLetter(i+12)+"$"+3 + ":$" + columnToLetter(i+10)+",\"S\""+ ViewSortAdd(values);
  //       k+=2;
  //     }
  //     if(values[16][3]){
  //       ViewArray[i*tolerance+k][j+4] = "="+columnToLetter(j+5)+(i*tolerance+2+k)+"/$"+columnToLetter(j+5)+(3)+"*100";
  //       ViewArray[i*tolerance+k+1][j+4] = "=COUNTIFS('Data Master'!$J$3:$J,"+ columnToLetter(j+5) +"$2,'Data Master'!$H$3:$H,$A$3,'Data Master'!$"+columnToLetter(i+12)+"$"+3 + ":$" + columnToLetter(i+10)+",\"I\""+ ViewSortAdd(values);
  //       k+=2;
  //     }
  //     if(values[17][3]){
  //       ViewArray[i*tolerance+k][j+4] = "="+columnToLetter(j+5)+(i*tolerance+2+k)+"/$"+columnToLetter(j+5)+(3)+"*100";
  //       ViewArray[i*tolerance+k+1][j+4] = "=COUNTIFS('Data Master'!$J$3:$J,"+ columnToLetter(j+5) +"$2,'Data Master'!$H$3:$H,$A$3,'Data Master'!$"+columnToLetter(i+12)+"$"+3 + ":$" + columnToLetter(i+10)+",\"R\""+ ViewSortAdd(values);
  //       k+=2;
  //     }
  //   }
  // }
  DataCulView.getRange(row,column,toleranceCount * maxRow+5, MaxColumn+5).setValues(ViewArray);
}
function ViewSortAdd(values, DataCulMaster, DataCulSetting)
{
  let DatabaseName = DataCulMaster.getName();
  let PengaturanName = DataCulSetting.getName();
  let StringAdd = "";
  let leftCompareSign = "";
  let rightCompareSign = "";
  if(values[3][1])
  {
    if(values[3][3] == "Luar")
    {
      leftCompareSign = "<";
      rightCompareSign = ">";
    }else{
      leftCompareSign = ">";
      rightCompareSign = "<";
    }
    StringAdd = StringAdd + ","+ databasePath(DatabaseName,values[3][0])+",\"" + leftCompareSign +"\" & '"+ PengaturanName +"'!$H$8"+ ","+ databasePath(DatabaseName,values[3][0])+",\"" + rightCompareSign +"\" & '"+ PengaturanName +"'!$I$8";
  }
  if(values[4][1])
  {
    StringAdd = StringAdd + ","+ databasePath(DatabaseName,values[4][0])+",\"" +values[4][3]+"\"";
  }
  if(values[5][1])
  {
    StringAdd = StringAdd + ","+ databasePath(DatabaseName,values[5][0])+",\"" +values[5][3]+"\"";
  }
  if(values[6][1])
  {
    if(values[6][3] == "Luar")
    {
      leftCompareSign = "<";
      rightCompareSign = ">";
    }else{
      leftCompareSign = ">";
      rightCompareSign = "<";
    }
    StringAdd = StringAdd + ","+ databasePath(DatabaseName,values[6][0])+",\"" + leftCompareSign +"\" & '"+ PengaturanName +"'!$H$11"+ ","+ databasePath(DatabaseName,values[6][0])+",\"" + rightCompareSign +"\" & '"+ PengaturanName +"'!$I$11";
  }
  if(values[7][1])
  {
    StringAdd = StringAdd + ","+ databasePath(DatabaseName,values[7][0])+",\"" +values[7][3]+"\"";
  }
  if(values[8][1])
  {
    StringAdd = StringAdd + ","+ databasePath(DatabaseName,values[8][0])+",\"" +values[8][3]+"\"";
  }
  if(values[9][1])
  {
    StringAdd = StringAdd + ","+ databasePath(DatabaseName,values[9][0])+",\"" +values[9][3]+"\"";
  }
  StringAdd = StringAdd + ")";
  return StringAdd;
}
function samplePath(sampleValues, sampleCount)
{
  if(sampleCount>0)
  {
    let StringSample = "{";
    for(let i = 0, j = 0; i < sampleCount;j++)
    {
      if(i>0)
      {
        StringSample = StringSample + ","
      }
      if(sampleValues[j][1])
      {
        StringSample = StringSample + "\"" + sampleValues[j][2] + "\"";
        i++;
      }
    }
    StringSample = StringSample + "}";
    return StringSample;
  }else{
    return "$A$3";
  }
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