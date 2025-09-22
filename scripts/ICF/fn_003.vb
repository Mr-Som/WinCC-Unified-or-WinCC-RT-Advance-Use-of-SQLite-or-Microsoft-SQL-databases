Sub VBFN_003()

    On Error Resume Next ' Enable error handling

    Dim objConn, objRS, sqlQuery, checkQuery
    Dim dbPath, strError, logFile, fso, file, timeStamp
    Dim test_id, drain_aux_reservoir, visual_inspection, greasing, fr_bp_value, fr_fp_value

    ' SQLite database path
    dbPath = HmiRuntime.SmartTags("DB_PATH")
    logFile = HmiRuntime.SmartTags("LOG_PATH")

    ' Get SmartTag values
    test_id = HmiRuntime.SmartTags("NEW_RTR_TEST_ID")

    ' Convert 1/0 to Yes/No
    If HmiRuntime.SmartTags("DRAIN_AUX_RESERVOIR") = 2 Then
        drain_aux_reservoir = "yes"
    Else
        drain_aux_reservoir = "no"
    End If

    If HmiRuntime.SmartTags("VISUAL_INSPECTION") = 2 Then
        visual_inspection = "yes"
    Else
        visual_inspection = "no"
    End If

    If HmiRuntime.SmartTags("GREASING") = 2 Then
        greasing = "yes"
    Else
        greasing = "no"
    End If

    fr_bp_value = HmiRuntime.SmartTags("FR_BP_VALUE")
    fr_fp_value = HmiRuntime.SmartTags("FR_FP_VALUE")

    ' Create ADODB connection object
    Set objConn = CreateObject("ADODB.Connection")
    objConn.Open "Driver={SQLite3 ODBC Driver};Database=" & dbPath & ";"

    ' Check if ID exists
    checkQuery = "SELECT COUNT(*) AS cnt FROM tbl_icf_01 WHERE id = " & test_id
    Set objRS = objConn.Execute(checkQuery)

    If objRS("cnt") > 0 Then
        ' If exists → UPDATE
        sqlQuery = "UPDATE tbl_icf_01 SET " & _
                   "drain_aux_reservoir='" & drain_aux_reservoir & "'," & _
                   "visual_inspection='" & visual_inspection & "'," & _
                   "greasing='" & greasing & "'," & _
                   "fr_bp_value='" & fr_bp_value & "'," & _
                   "fr_fp_value='" & fr_fp_value & "' " & _
                   "WHERE id=" & test_id
    Else
        ' If not exists → INSERT
        sqlQuery = "INSERT INTO tbl_icf_01 (" & _
                   "id, drain_aux_reservoir, visual_inspection, greasing, fr_bp_value, fr_fp_value" & _
                   ") VALUES (" & _
                   test_id & ",'" & drain_aux_reservoir & "','" & visual_inspection & "','" & greasing & "','" & fr_bp_value & "','" & fr_fp_value & "')"
    End If

    ' Execute SQL query
    objConn.Execute sqlQuery

    ' Error handling
    If Err.Number <> 0 Then
        strError = "VBFN_003 Error: " & Err.Description
        timeStamp = Now

        ' Log error in text file
        Set fso = CreateObject("Scripting.FileSystemObject")
        Set file = fso.OpenTextFile(logFile, 8, True)
        file.WriteLine timeStamp & " - " & strError
        file.Close
        Err.Clear
    End If

    ' Close connection
    objConn.Close
    Set objConn = Nothing
    Set objRS = Nothing

End Sub