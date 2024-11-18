# 문제 25 - Create Personal Flag

## 문제 설명
플래그 생성 시스템
이 문제는 사용자가 직접 플래그를 생성하는 문제입니다. 생성된 플래그는 데이터베이스에 저장되며, 이후 다른 문제들의 플래그로 사용될 수 있습니다.

## 풀이 과정
1. SQL 쿼리를 통해 현재 자신의 테이블 구조를 확인합니다.
2. 플래그 입력창에 원하는 플래그 값을 입력합니다.
3. 제출 버튼을 클릭하여 플래그를 생성합니다.
4. SQL 쿼리로 플래그가 정상적으로 저장되었는지 확인합니다.

### 플래그 생성 예시
```sql
mysql> select * from admin;
+----------+------+
| NICKNAME | FLAG |
+----------+------+
| admin    | weak |    
+----------+------+
```

## 힌트
1. userDB의 자신의 테이블에 플래그를 저장할 수 있습니다.
2. SQL 터미널을 통해 테이블 구조와 데이터를 확인할 수 있습니다.

## 사용된 기술
- 데이터베이스 관리: MySQL을 사용한 플래그 저장 및 관리
- SQL: 데이터베이스 쿼리를 통한 데이터 확인
- PHP: 서버 사이드 스크립트로 플래그 생성 처리

## 최종 플래그
```
weak