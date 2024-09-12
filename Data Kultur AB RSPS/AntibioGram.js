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
  if(e.source.getActiveSheet().getRange(1,1).getValue() == "View Script") 
  {
    if(e.range.getRow() == 4 && e.range.getColumn() == 3)
    {
      viewHideColumn(e);
    }
    if(e.range.getRow() > 4 && (e.range.getColumn() == 4 || e.range.getColumn() == 5))
    {
      console.log("A");
      viewSortRow(e);
    }
  }
}
function viewHideColumn(e)
{
  let DataCulView = e.source.getActiveSheet();
  if(DataCulView.getRange(1,3).getValue() == "Jumlah Isolat")
  {
    let maxRow = DataCulView.getRange(1,4).getValue();
    if(e.range.getCell(1,1).getValue() == true)
    {
      let viewArray = DataCulView.getRange(5,3,maxRow).getValues();

      for(let i = 0; i< maxRow; i++)
      {
        if(viewArray[i] == "0")
        {
          DataCulView.hideRows(i+5);
        }
      }
    }else{
      DataCulView.showRows(5,maxRow);
    }
  }else if(DataCulView.getRange(1,3).getValue() == "Jumlah Obat"){
    let maxRow = DataCulView.getRange(1,4).getValue();
    if(e.range.getCell(1,1).getValue() == true)
    {
      let viewArray = DataCulView.getRange(6,4,maxRow).getValues();

      for(let i = 0; i< maxRow; i++)
      {
        if(viewArray[i] == "0")
        {
          DataCulView.hideRows(i+5);
          DataCulView.hideRows(i+6);
        }
      }
    }else{
      DataCulView.showRows(5,maxRow);
    }
  }
}
function viewSortRow(e)
{
  let DataCulView = e.source.getActiveSheet();
  let row = e.range.getRow();
  let column = e.range.getColumn();
  let maxRow = DataCulView.getRange(1,4).getValue();
  let maxColumn = DataCulView.getRange(2,4).getValue();
  let boolsorting = false;
  if(DataCulView.getRange(3,4).getValue() == "Naik")
  {
    boolsorting = true;
  }else{
    boolsorting = false;
  }
  if(DataCulView.getRange(1,3).getValue() == "Jumlah Isolat")
  {
    if(e.range.getCell(1,1).getValue() == true)
    {
      DataCulView.getRange(maxRow + 10,5).setValue("=Transpose(SORT(Transpose(E1:"+columnToLetter(maxColumn+3)+(maxRow+7)+"),"+row+","+boolsorting+"))");
      DataCulView.hideRows(maxRow + 14 ,maxRow+1);
      DataCulView.showRows(maxRow + 9 + row);
    }
  }else if(DataCulView.getRange(1,3).getValue() == "Jumlah Obat"){
    if(e.range.getCell(1,1).getValue() == true)
    {
      DataCulView.getRange(maxRow + 10,6).setValue("=Transpose(SORT(Transpose(F1:"+columnToLetter(maxColumn+3)+(maxRow+7)+"),"+row+","+boolsorting+"))");
      DataCulView.hideRows(maxRow + 14 ,maxRow+1);
      DataCulView.showRows(maxRow + 9 + row);
    }
  }
}
function ViewSettingChangeCheck(e)
{
  let DataCulSetting = e.source.getSheetByName("Pengaturan");
  let SettingVariableValues = DataCulSetting.getRange(3,2,14).getValues();
  let DatabaseName = SettingVariableValues[0].toString();
  let ViewName = SettingVariableValues[1].toString();
  
  let DataCulMaster = e.source.getSheetByName(DatabaseName);
  if( DataCulMaster)
  {
    let DataCulView = e.source.getSheetByName(ViewName);
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
  let bakteriStart = letterToColumn(SettingVariableValues[8].toString());
  let maxObat = SettingVariableValues[10];
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

  if(toleranceCount > 0 && maxBakteri > 0 && maxObat > 0){
    DataCulView.clear();
    DataCulView.getRange(1,1,maxObat*toleranceCount*2,maxObat*toleranceCount*2).clearDataValidations();
    if(WriteBerdasarkan == "Bakteri")
    {
      ViewWriteBacteria(DataCulMaster, DataCulSetting, DataCulView, sortingValues, sampleValues, sampleCount, toleranceValues, toleranceCount * 2, 1 ,1 , maxBakteri, maxObat,  bakteriStart, obatStart,databaseObatStart);
      DataCulView.setFrozenColumns(3);
      var cell = DataCulView.getRange(5,4,maxBakteri*1+1);
      var rule = SpreadsheetApp.newDataValidation().requireCheckbox().build();
      cell.setDataValidation(rule);
    }else{
      ViewWriteObat(DataCulMaster, DataCulSetting, DataCulView, sortingValues, sampleValues, sampleCount, toleranceValues, toleranceCount * 2 , 1 ,1 , maxObat , maxBakteri,obatStart ,bakteriStart, databaseObatStart);
      DataCulView.setFrozenColumns(4);
      var cell = DataCulView.getRange(5,5,maxObat*toleranceCount*2);
      var rule = SpreadsheetApp.newDataValidation().requireCheckbox().build();
      cell.setDataValidation(rule);
    }
    DataCulView.autoResizeColumn(2);
    DataCulView.setFrozenRows(3);
    var cell = DataCulView.getRange('C4');
    var rule = SpreadsheetApp.newDataValidation().requireCheckbox().build();
    cell.setDataValidation(rule);

    cell = DataCulView.getRange('D3');
    rule = SpreadsheetApp.newDataValidation().requireValueInList(["Turun","Naik"], true).build();
    cell.setDataValidation(rule);
    if(sampleCount == 0)
    {
      cell = DataCulView.getRange('B1');
      rule = SpreadsheetApp.newDataValidation().requireValueInList(['*', 'Sputum', 'Darah', 'Urin', 'Feses', 'Swab Dasar Luka/Pus', 'Cairan tubuh lain'], true).build();
      cell.setDataValidation(rule);
      cell.setValue("*");
    }
    if(sortingValues[5][1] == false)
    {
      cell = DataCulView.getRange('B2');
      rule = SpreadsheetApp.newDataValidation().requireValueInList(["*","Intensif","Non-intensif"], true).build();
      cell.setDataValidation(rule);
      cell.setValue("*");
    }
  }
}

function ViewWriteBacteria(DataCulMaster, DataCulSetting, DataCulView, sortingValues, sampleValues, sampleCount, toleranceValues, toleranceCount, row, column, maxRow, maxColumn, startRow, startColumn, databaseObatStart)
{
  let k = 0;
  let DatabaseName = DataCulMaster.getName();
  let sampleName = samplePath(sampleValues, sampleCount);
  let viewSorted = ViewSortAdd(sortingValues, DataCulMaster, DataCulSetting);
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
        ViewArray[i+k+4][3] = "FALSE"; 
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
    k = 4;
    if(columnArray[l][0])
    {
      ViewArray[0][i*toleranceCount+k] = columnArray[l][0];
    }
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
      k = 4; 
      if(columnArray[l][1])
      {
        if(toleranceValues[0][0]){
          ViewArray[i+4+n][j*toleranceCount+k] = "="+columnToLetter(j*toleranceCount+2+k)+(i+n+5)+"/$"+columnToLetter(3)+(i+n+5)+"*100";
          ViewArray[i+4+n][j*toleranceCount+k+1] = "=COUNTIFS("+ databasePath(DatabaseName,sortingValues[0][0]) +",$B"+ (i+n+5) +","+ databasePath(DatabaseName,sampleValues[0][0]) +","+ sampleName+",'"+DatabaseName+"'!$"+columnToLetter(l+databaseObatStart)+"$"+3 + ":$" + columnToLetter(l+databaseObatStart)+",\"S\""+ viewSorted;
          k+=2;
        }
        if(toleranceValues[1][0]){
          ViewArray[i+4+n][j*toleranceCount+k] = "="+columnToLetter(l*toleranceCount+2+k)+(i+n+5)+"/$"+columnToLetter(3)+(i+n+5)+"*100";
          ViewArray[i+4+n][j*toleranceCount+k+1] = "=COUNTIFS("+ databasePath(DatabaseName,sortingValues[0][0]) +",$B"+ (i+n+5) +","+ databasePath(DatabaseName,sampleValues[0][0]) +","+ sampleName+",'"+DatabaseName+"'!$"+columnToLetter(l+databaseObatStart)+"$"+3 + ":$" + columnToLetter(l+databaseObatStart)+",\"I\""+ viewSorted;
          k+=2;
        }
        if(toleranceValues[2][0]){
          ViewArray[i+4+n][j*toleranceCount+k] = "="+columnToLetter(j*toleranceCount+2+k)+(i+n+5)+"/$"+columnToLetter(3)+(i+n+5)+"*100";
          ViewArray[i+4+n][j*toleranceCount+k+1] = "=COUNTIFS("+ databasePath(DatabaseName,sortingValues[0][0]) +",$B"+ (i+n+5) +","+ databasePath(DatabaseName,sampleValues[0][0]) +","+ sampleName+",'"+DatabaseName+"'!$"+columnToLetter(l+databaseObatStart)+"$"+3 + ":$" + columnToLetter(l+databaseObatStart)+",\"R\""+ viewSorted;
          k+=2;
        }
        j++;
      }
    }
  }
  ViewArray[0][0] = "View Script";
  ViewArray[0][2] = "Jumlah Isolat";
  ViewArray[0][3] = maxRow;
  ViewArray[1][2] = "Jumlah Obat";
  ViewArray[1][3] = maxColumn*2;
  ViewArray[2][3] = sortingValues[1][3];
  ViewArray[2][1] = "Total";
  ViewArray[2][2] = "=COUNTIF("+ databasePath(DatabaseName,sampleValues[0][0]) +","+ sampleName+")";
  ViewArray[3][1] = "Hide Empty Row";
  ViewArray[3][2] = "FALSE";
  ViewArray[3][3] = "Sort";

  DataCulView.getRange(row,column,maxRow+5,toleranceCount  * maxColumn+5).setValues(ViewArray);
}

function ViewWriteObat(DataCulMaster, DataCulSetting, DataCulView, sortingValues, sampleValues, sampleCount, toleranceValues, toleranceCount, row, column, maxRow, maxColumn, startRow, startColumn, databaseObatStart)
{

  let k = 0;
  let DatabaseName = DataCulMaster.getName();
  let sampleName = samplePath(sampleValues, sampleCount);
  let viewSorted = ViewSortAdd(sortingValues, DataCulMaster, DataCulSetting);

  let ViewArray = new Array();
  for(let i = 0; i < toleranceCount * maxRow+5;i++)
  {
    ViewArray[i] = new Array();
    for(let j = 0; j <  maxColumn+5; j++)
    {
      ViewArray[i][j]=null;
    }
  }
  let numCount = DataCulSetting.getRange(3,startRow+1).getValue();
  let rowArray = DataCulSetting.getRange(5,startRow, maxRow, 3).getValues();
  for(let i = 0, l = 0; i < numCount;l++)
  {
    k = 4;
    if(rowArray[l][0])
    {
      ViewArray[i*toleranceCount+k][0] = rowArray[l][0];
    }
    if(rowArray[l][1])
    {
      ViewArray[i*toleranceCount+k][1] = rowArray[l][2];
      if(toleranceValues[0][0]){
        ViewArray[i*toleranceCount+k][2]= "%Sensitive";
        ViewArray[i*toleranceCount+k+1][2]= "Total";
        ViewArray[i*toleranceCount+k][4] = "FALSE";
        ViewArray[i*toleranceCount+k+1][4] = "FALSE";
        if(sortingValues[0][1])
        {
          if(sortingValues[0][3] == "Termasuk")
          {
            ViewArray[i*toleranceCount+k+1][3] = "=COUNTIFS('"+DatabaseName+"'!$"+columnToLetter(databaseObatStart+l)+"$"+3 + ":$" + columnToLetter(databaseObatStart+l)+",\"S\","+ databasePath(DatabaseName,sampleValues[0][0]) +","+ sampleName + viewSorted;
          }else{
            ViewArray[i*toleranceCount+k+1][3] = "=COUNTIFS('"+DatabaseName+"'!$"+columnToLetter(databaseObatStart+l)+"$"+3 + ":$" + columnToLetter(databaseObatStart+l)+",\"S\","+ databasePath(DatabaseName,sampleValues[0][0]) +","+ sampleName +")-COUNTIFS('"+DatabaseName+"'!$"+columnToLetter(databaseObatStart+l)+"$"+3 + ":$" + columnToLetter(databaseObatStart+l)+",\"S\","+ databasePath(DatabaseName,sampleValues[0][0]) +","+ sampleName + viewSorted;
          }
        }else{
          ViewArray[i*toleranceCount+k+1][3] = "=COUNTIFS('"+DatabaseName+"'!$"+columnToLetter(databaseObatStart+l)+"$"+3 + ":$" + columnToLetter(databaseObatStart+l)+",\"S\","+ databasePath(DatabaseName,sampleValues[0][0]) +","+ sampleName +")";
        }
        k+=2;
      }
      if(toleranceValues[1][0]){
        ViewArray[i*toleranceCount+k][2] = "%Intermediate";
        ViewArray[i*toleranceCount+k+1][2] = "Total";
        ViewArray[i*toleranceCount+k][4] = "FALSE";
        ViewArray[i*toleranceCount+k+1][4] = "FALSE";
        if(sortingValues[0][1])
        {
          if(sortingValues[0][3] == "Termasuk")
          {
            ViewArray[i*toleranceCount+k+1][3] = "=COUNTIFS('"+DatabaseName+"'!$"+columnToLetter(databaseObatStart+l)+"$"+3 + ":$" + columnToLetter(databaseObatStart+l)+",\"I\","+ databasePath(DatabaseName,sampleValues[0][0]) +","+ sampleName + viewSorted;
          }else{
            ViewArray[i*toleranceCount+k+1][3] = "=COUNTIFS('"+DatabaseName+"'!$"+columnToLetter(databaseObatStart+l)+"$"+3 + ":$" + columnToLetter(databaseObatStart+l)+",\"I\","+ databasePath(DatabaseName,sampleValues[0][0]) +","+ sampleName +")-COUNTIFS('"+DatabaseName+"'!$"+columnToLetter(databaseObatStart+l)+"$"+3 + ":$" + columnToLetter(databaseObatStart+l)+",\"I\","+ databasePath(DatabaseName,sampleValues[0][0]) +","+ sampleName + viewSorted;
          }
        }else{
          ViewArray[i*toleranceCount+k+1][3] = "=COUNTIFS('"+DatabaseName+"'!$"+columnToLetter(databaseObatStart+l)+"$"+3 + ":$" + columnToLetter(databaseObatStart+l)+",\"I\","+ databasePath(DatabaseName,sampleValues[0][0]) +","+ sampleName +")";
        }
        k+=2;
      }
      if(toleranceValues[2][0]){
        ViewArray[i*toleranceCount+k][2] = "%Resistensi";
        ViewArray[i*toleranceCount+k+1][2] = "Total";
        ViewArray[i*toleranceCount+k][4] = "FALSE";
        ViewArray[i*toleranceCount+k+1][4] = "FALSE";
        if(sortingValues[0][1])
        {
          if(sortingValues[0][3] == "Termasuk")
          {
            ViewArray[i*toleranceCount+k+1][3] = "=COUNTIFS('"+DatabaseName+"'!$"+columnToLetter(databaseObatStart+l)+"$"+3 + ":$" + columnToLetter(databaseObatStart+l)+",\"R\","+ databasePath(DatabaseName,sampleValues[0][0]) +","+ sampleName + viewSorted;
          }else{
            ViewArray[i*toleranceCount+k+1][3] = "=COUNTIFS('"+DatabaseName+"'!$"+columnToLetter(databaseObatStart+l)+"$"+3 + ":$" + columnToLetter(databaseObatStart+l)+",\"R\","+ databasePath(DatabaseName,sampleValues[0][0]) +","+ sampleName +")-COUNTIFS('"+DatabaseName+"'!$"+columnToLetter(databaseObatStart+l)+"$"+3 + ":$" + columnToLetter(databaseObatStart+l)+",\"R\","+ databasePath(DatabaseName,sampleValues[0][0]) +","+ sampleName + viewSorted;
          }
        }else{
          ViewArray[i*toleranceCount+k+1][3] = "=COUNTIFS('"+DatabaseName+"'!$"+columnToLetter(databaseObatStart+l)+"$"+3 + ":$" + columnToLetter(databaseObatStart+l)+",\"R\","+ databasePath(DatabaseName,sampleValues[0][0]) +","+ sampleName +")";
        }
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

    for(let j = 0, l = 0; j < numCount;l++)
    {
      if(columnArray[l][0])
      {
        j++;
        ViewArray[1][i+5] = columnArray[l][1]; 
        if(sortingValues[0][1])
        {
          if(sortingValues[0][3] == "Termasuk")
          {
            ViewArray[2][i+5] = "=COUNTIFS("+ databasePath(DatabaseName,sortingValues[0][0]) +","+columnToLetter(i+6)  +"$2,"+ databasePath(DatabaseName,sampleValues[0][0]) +","+ sampleName + viewSorted;
          }else{
            ViewArray[2][i+5] = "=COUNTIFS("+ databasePath(DatabaseName,sortingValues[0][0]) +","+columnToLetter(i+6)  +"$2,"+ databasePath(DatabaseName,sampleValues[0][0]) +","+ sampleName +") - COUNTIFS("+ databasePath(DatabaseName,sortingValues[0][0]) +",$B"+ (i+6) +","+ databasePath(DatabaseName,sampleValues[0][0]) +","+ sampleName +  viewSorted;
          }
        }else{
          ViewArray[2][i+5] = "=COUNTIFS("+ databasePath(DatabaseName,sortingValues[0][0]) +","+columnToLetter(i+6)  +"$2,"+ databasePath(DatabaseName,sampleValues[0][0]) +","+ sampleName +")";
        }
        i++
      }
    }
    index += 4;
  }
  for(let i = 0; i < maxRow; i++)
  {
    for(let j = 0; j < maxColumn; j++)
    {
      k = 4; 
      if(toleranceValues[0][0]){
        ViewArray[i*toleranceCount+k][j+5] = "="+columnToLetter(j+6)+(i*toleranceCount+2+k)+"/$"+columnToLetter(j+6)+(3)+"*100";
        ViewArray[i*toleranceCount+k+1][j+5] = "=COUNTIFS("+ databasePath(DatabaseName,sortingValues[0][0]) +","+ columnToLetter(j+6) +"$2,"+ databasePath(DatabaseName,sampleValues[0][0]) +","+ sampleName+",'"+DatabaseName+"'!$"+columnToLetter(i+databaseObatStart)+"$"+3 + ":$" + columnToLetter(i+databaseObatStart)+",\"S\""+ viewSorted;
        k+=2;
      }
      if(toleranceValues[1][0]){
        ViewArray[i*toleranceCount+k][j+5] = "="+columnToLetter(j+6)+(i*toleranceCount+2+k)+"/$"+columnToLetter(j+6)+(3)+"*100";
        ViewArray[i*toleranceCount+k+1][j+5] = "=COUNTIFS("+ databasePath(DatabaseName,sortingValues[0][0]) +","+ columnToLetter(j+6) +"$2,"+ databasePath(DatabaseName,sampleValues[0][0]) +","+ sampleName+",'"+DatabaseName+"'!$"+columnToLetter(i+databaseObatStart)+"$"+3 + ":$" + columnToLetter(i+databaseObatStart)+",\"I\""+ viewSorted;
        k+=2;
      }
      if(toleranceValues[2][0]){
        ViewArray[i*toleranceCount+k][j+5] = "="+columnToLetter(j+6)+(i*toleranceCount+2+k)+"/$"+columnToLetter(j+6)+(3)+"*100";
        ViewArray[i*toleranceCount+k+1][j+5] = "=COUNTIFS("+ databasePath(DatabaseName,sortingValues[0][0]) +","+ columnToLetter(j+6) +"$2,"+ databasePath(DatabaseName,sampleValues[0][0]) +","+ sampleName+",'"+DatabaseName+"'!$"+columnToLetter(i+databaseObatStart)+"$"+3 + ":$" + columnToLetter(i+databaseObatStart)+",\"R\""+ viewSorted;
        k+=2;
      }
    }
  }
  ViewArray[0][0] = "View Script";
  ViewArray[0][2] = "Jumlah Obat";
  ViewArray[0][3] = maxRow * toleranceCount;
  ViewArray[1][2] = "Jumlah Isolat";
  ViewArray[1][3] = maxColumn;
  ViewArray[2][3] = sortingValues[1][3];
  ViewArray[2][1] = "Total";
  ViewArray[2][2] = "=COUNTIFS('"+DatabaseName+"'!$"+columnToLetter(databaseObatStart)+"$"+3 + ":$" + columnToLetter(Number(databaseObatStart)+Number(maxRow))+","+tolerancePath(toleranceValues , toleranceCount/2)+")";
  ViewArray[3][1] = "Hide Empty Row";
  ViewArray[3][2] = "FALSE";
  ViewArray[3][4] = "Sort";
  DataCulView.getRange(row,column,toleranceCount * maxRow+5, maxColumn+5).setValues(ViewArray);
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
  }else{
    StringAdd = StringAdd + ","+ databasePath(DatabaseName,values[5][0])+",$B$2";
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
function tolerancePath(toleranceValues, toleranceCount)
{
  if(toleranceCount>0)
  {
    let StringTolerance ="{";
    for(let i = 0, j = 0; i < toleranceCount;j++)
    {
      if(i>0)
      {
        StringTolerance = StringTolerance + ","
      }
      if(toleranceValues[j][0])
      {
        StringTolerance = StringTolerance + "\"" + toleranceValues[j][1] + "\"";
        i++;
      }
    }
    StringTolerance = StringTolerance + "}";
    return StringTolerance;
  }else{
    return "\"S\"";
  }
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
    return "$B$1";
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